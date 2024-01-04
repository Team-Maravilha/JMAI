<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/head.php") ?>

<style>
    .fc .fc-daygrid-dot-event {
        color: #ffffff !important;
    }

    .fc-daygrid-event-dot {

        border: calc(var(--fc-daygrid-event-dot-width, 8px)/ 2) solid #ffffff !important;
    }

    .fc-daygrid-event {
        cursor: pointer;
    }
</style>

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="false" data-kt-app-sidebar-fixed="false" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">

    <div class="app-container container-xxxl">
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <div class="d-flex flex-column flex-column-fluid">
                <div id="kt_app_content" class="app-content">

                    <div class="row g-6">
                        <div class="order-2 order-xl-1 col-12 col-xl-8">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div id="schedule" class="h-100 min-h-500px min-h-md-600px min-h-lg-800px"></div>
                                </div>
                            </div>
                        </div>
                        <div id="calendar-sidebar" class="order-1 order-xl-2 col-12 col-xl-4">
                            <div data-type="default" class="card">
                                <div class="card-header card-header-stretch gap-4 flex-wrap min-h-70px">
                                    <h2 class="card-title fw-bold">Informação Agendamento</h2>
                                </div>

                                <div class="card-body p-4 p-lg-6">
                                    <div class="tab-content" id="tab-content">
                                        <div class="tab-pane fade show active" id="tab-1" role="tabpanel">
                                            <div class="align-items-center">
                                                <div class="text-center my-10">
                                                    <i class="ki-solid ki-information-2 text-primary fs-5tx"></i>
                                                    <h4 class="text-muted fw-bold fs-4">Clique sobre um agendamento para obter mais informações!</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAREFA -->
                            <div data-type="view-agendamento" style="display: none;" class="card">
                                <div class="card-header card-header-stretch gap-4 flex-wrap min-h-70px">
                                    <h2 class="card-title fw-bold">Informação Agendamento - Junta Médica</h2>
                                    <div class="card-toolbar align-items-center">
                                        <button class="btn btn-sm btn-icon btn-active-light-primary" data-action="close">
                                            <span class="svg-icon svg-icon-muted svg-icon-2"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.2657 11.4343L15.45 7.25C15.8642 6.83579 15.8642 6.16421 15.45 5.75C15.0358 5.33579 14.3642 5.33579 13.95 5.75L8.40712 11.2929C8.01659 11.6834 8.01659 12.3166 8.40712 12.7071L13.95 18.25C14.3642 18.6642 15.0358 18.6642 15.45 18.25C15.8642 17.8358 15.8642 17.1642 15.45 16.75L11.2657 12.5657C10.9533 12.2533 10.9533 11.7467 11.2657 11.4343Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <?php require_once "componentes_agenda/ver.php";
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/foo.php") ?>
    <script src="/assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    <script>

        function isJSON(str) {
            try {
                return (JSON.parse(str) && !!str);
            } catch (e) {
                return false;
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            const initDocument = (function() {
                let calendar;
                let calendarElement = document.getElementById("schedule");
                let containerEl = document.getElementById("external-events");
                let calendarOptions;
                let idClickedEvent;
                let calendarView;
                const calendarBlockElement = document.querySelector("#schedule").parentElement.parentElement;
                const calendarBlockUI = new KTBlockUI(calendarBlockElement, {
                    overlayClass: "bg-white bg-opacity-75",
                    message: `<div class="blockui-message text-gray-500"><span class="spinner-border text-primary me-4"></span> Aguarde...</div>`
                });

                let draggableEvent_consultationMedic = null;

                let draggableEvent_consultationPatient = null;
                let draggableEvent_consultationDuration = null;
                let draggableEvent_consultationSpecialty = null;
                let draggableEvent_consultationRoom = null;

                let clickedTaskEvent = null;
                let eventOverride = false;

                let editConsultationDuration = null;

                // ? CALENDAR SIDEBAR
                const calendarSidebar = $("#calendar-sidebar");
                const calendarSidebarDefault = calendarSidebar.find(`[data-type="default"]`);
                const calendarSidebarViewTask = calendarSidebar.find(`[data-type="view-agendamento"]`);

                const calendarSidebarTaskBlockUIElement = calendarSidebarViewTask.get(0);
                const calendarSidebarTaskBlockUI = new KTBlockUI(calendarSidebarTaskBlockUIElement, {
                    message: `<div class="blockui-message text-gray-500"><span class="spinner-border text-primary me-4"></span> Aguarde...</div>`,
                    overlayClass: "bg-body"
                });

                const calendarSidebarEditTask = calendarSidebar.find(`[data-type="edit-agendamento"]`);
                $(calendarSidebarViewTask).find(`[data-action="close"]`).on("click", () => {
                    calendarSidebarCloseAll();
                    calendarSidebarDefault.show();
                });
                $(calendarSidebarEditTask).find(`[data-action="close"]`).on("click", () => {
                    calendarSidebarEditTask.hide();
                    calendarSidebarViewTask.show();
                });

                // ? Accordion - Task
                const accordionTaskEl = document.querySelector("#accordion-agendamento-body");


                // ! |===========================|
                // ! |======== FUNCTIONS ========|
                // ! |===========================|

                function removePopover() {
                    $(".popover").remove();
                }

                function calendarSidebarCloseAll() {
                    calendarSidebarDefault.hide();
                    calendarSidebarViewTask.hide();
                    calendarSidebarEditTask.hide();
                }

                function initCalendar() {
                    calendarBlockUI.block();

                    function handleClick(info) {
                        if (info.event.display === "background") return;

                        calendarSidebarCloseAll();
                        const event = info.event;
                        const eventType = event.extendedProps.event_type;

                        if (typeof event.extendedProps.event_type === "undefined" || (eventType !== "consultation" && eventType !== "agendamento")) {
                            toastr.error("De momento só está disponível a visualização de consultas");
                            return;
                        }

                        switch (eventType) {
                            case "agendamento":
                                calendarSidebarTaskBlockUI.release();
                                toastr.remove();
                                calendarSidebarTaskBlockUI.block();
                                calendarSidebarViewTask.show();
                                clickedTaskEvent = event.id;

                                setTimeout(() => {
                                    calendarSidebarTaskBlockUI.release();
                                }, 300);

                                console.log(event.extendedProps);

                                $(calendarSidebarViewTask).find(`[data-action="finalize"]`).on("click", () => initViewTask());

                                if (event.extendedProps.status === 1) $(calendarSidebarViewTask).find(`[data-action="finalize"]`).hide();
                                else $(calendarSidebarViewTask).find(`[data-action="finalize"]`).show();

                                $(calendarSidebarViewTask).find(`[data-text="title"]`).text(event.title);
                                $(calendarSidebarViewTask).find(`[data-text="date"]`).text(moment(event.start).format("DD/MM/YYYY"));
                                $(calendarSidebarViewTask).find(`[data-text="start-hour"]`).text(moment(event.start).format("HH:mm"));
                                $(calendarSidebarViewTask).find(`[data-text="end-hour"]`).text(moment(event.end).format("HH:mm"));

                                $(calendarSidebarViewTask).find(`[data-text="req"]`).html(`
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="fs-6 fw-bold">Tipo de Requerimento: </div><span>${event.extendedProps.requerimento.tipo_requerimento}</span>
                                    </div>
                                `);

                                $(calendarSidebarViewTask).find(`[data-text="patient"]`).html(`
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="fs-6 fw-bold">Nome: </div><span>${event.extendedProps.utente.nome}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="fs-6 fw-bold">Numero de Utente: </div><span>${event.extendedProps.utente.numero_utente}</span>
                                    </div>
                                `);

                                $(calendarSidebarViewTask).find(`[data-text="medical_team"]`).html(`
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="fs-6 fw-bold">Nome: </div><span>${event.extendedProps.equipa_medica.nome}</span>
                                    </div>

                                    ${
                                        event.extendedProps.equipa_medica.medicos.length > 0 ?
                                        `
                                            <div class="d-flex flex-column mt-1">
                                                <div class="fs-6 fw-bold">Médicos: </div>
                                                <div class="d-flex flex-column gap-1">
                                                    ${event.extendedProps.equipa_medica.medicos.map((medico) => {
                                                        return `<span>${medico.nome}</span>`;
                                                    }).join("")}
                                                </div>
                                            </div>
                                        ` : ""
                                    }

                                `);
                                break;
                        }
                    }

                    function handleDidMount(info) {
                        const event = info.event;
                        const eventType = event.extendedProps.event_type;

                        switch (eventType) {
                            case "agendamento":
                                $(info.el).popover({
                                    title: () => {
                                        return `<span class="fw-bolder">Informação da Junta Médica</span>`;
                                    },
                                    content: () => {
                                        return `
										  <div class="row gy-3">
												<div class="col-12"><b>Título</b> <span class="d-block">${event.title}</span></span></div>
                                                <div class="col-12"><b>Data</b> <span class="d-block">${moment(event.start).format("DD/MM/YYYY")}</span></div>
												<div class="col-12"><b>Tipo Requerimento</b> <span class="d-block">${event.extendedProps.requerimento.tipo_requerimento}</div>
										  </div>
									 `;
                                    },
                                    html: true,
                                    sanitize: false,
                                    delay: {
                                        show: 500,
                                        hide: 0
                                    },
                                    placement: "top",
                                    trigger: "hover"
                                });
                                break;
                        }
                    }

                    const eventSources = [{
                            id: "holidays",
                            url: "data.php",
                            method: "POST",
                            extraParams: {
                                action: "holidays"
                            },
                            success: (response) => calendarBlockUI.release(),
                            failure: () => {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Não foi possível carregar os feriados",
                                    dismiss: "Ok"
                                });
                            }
                        },
                        {
                            id: "agendamentos",
                            url: "data.php",
                            method: "POST",
                            extraParams: {
                                action: "agendamentos"
                            },
                            success: (response) => calendarBlockUI.release(),
                            failure: () => {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Não foi possível carregar as tarefas",
                                    dismiss: "Ok"
                                });
                            }
                        }
                    ];

                    calendarOptions = {
                        locale: "pt",
                        initialDate: '<?php echo date("Y-m-d"); ?>',
                        initialView: "timeGridWeek",
                        slotLabelFormat: {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false,
                            omitZeroMinute: false,
                            meridiem: false
                        },
                        headerToolbar: {
                            //center: "resourcetimeGridMedic"//ADDED
                            center: "timeGridDay,timeGridWeek,dayGridMonth"
                        },
                        datesAboveResources: true, //ADDED
                        snapDuration: "00:30:00",
                        weekends: false,
                        displayEventTime: false,
                        slotMinTime: "08:00",
                        slotMaxTime: "18:00",
                        slotDuration: "01:00:00", // DEFINIR TAMANHO EVENTO
                        expandRows: true,
                        slotEventOverlap: false,
                        allDaySlot: false,
                        // selectable: true,
                        eventSources: eventSources,
                        eventClick: (info) => handleClick(info),
                        eventDidMount: (info) => handleDidMount(info),
                        datesSet: (info) => {
                            calendarView = info.view.type;
                            const eventsSources = calendar.getEventSources();

                            let avabilityExist = false;
                            eventsSources.forEach(eventSource => {
                                const id = eventSource.id;
                                if (id === "avability") avabilityExist = true;
                            });

                            if (calendarView === "resourcetimeGridMedic") {
                                if ($(accordionConsultation_selectMedic).val() !== "") {
                                    $(accordionConsultation_selectMedic).val("");
                                    $(accordionConsultation_selectMedic).trigger("change");

                                    eventsSources.forEach(eventSource => {
                                        const id = eventSource.id;
                                        if (id === "avability") eventSource.remove();
                                    });
                                    calendar.addEventSource({
                                        id: "avability",
                                        url: "./api.php",
                                        method: "POST",
                                        extraParams: {
                                            action: "avability"
                                        },
                                        success: (response) => {
                                            calendarBlockUI.release();
                                        },
                                        failure: () => {
                                            Swal.fire({
                                                icon: "error",
                                                title: "Oops...",
                                                text: "Não foi possível carregar as disponibilidades",
                                                dismiss: "Ok"
                                            });
                                        }
                                    });
                                }

                                if (!avabilityExist) {
                                    eventsSources.forEach(eventSource => {
                                        const id = eventSource.id;
                                        if (id === "avability") eventSource.remove();
                                    });

                                    calendar.addEventSource({
                                        id: "avability",
                                        url: "./api.php",
                                        method: "POST",
                                        extraParams: {
                                            action: "avability"
                                        },
                                        success: (response) => {
                                            calendarBlockUI.release();
                                        },
                                        failure: () => {
                                            Swal.fire({
                                                icon: "error",
                                                title: "Oops...",
                                                text: "Não foi possível carregar as disponibilidades",
                                                dismiss: "Ok"
                                            });
                                        }
                                    });
                                }

                                $(accordionConsultation_selectMedic).parent().hide();
                            } else {

                            }
                        }
                    };
                    calendar = new FullCalendar.Calendar(calendarElement, calendarOptions);
                    calendar.render();

                    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) calendar.setOption("height", Math.floor(window.innerHeight * 0.9));
                    else {
                        calendar.setOption("height", Math.floor(window.innerHeight * 0.8));
                    }
                }

                function initAccordion() {
                    $("#accordion .accordion-item button.accordion-button").each((index, element) => {
                        $(element).on("click", (e) => {
                            const target = $(e.target).attr("data-bs-target");
                            const externalEvents = $("#external-events");

                            externalEvents.find(".fc-event").each((index, element) => $(element).hide());

                            if (target === "#accordion-consultation-body") externalEvents.find(`.fc-event[data-event-type="consultation"]`).show();
                            else if (target === "#accordion-agendamento-body") externalEvents.find(`.fc-event[data-event-type="agendamento"]`).show();
                        });
                    });

                    $(`[name="recurring[range][]"]`).select2();
                }

                return {
                    init: () => {
                        initCalendar();

                        // ? Accordions
                        initAccordion();

                    }
                };
            })();

            initDocument.init();
        });
    </script>
</body>