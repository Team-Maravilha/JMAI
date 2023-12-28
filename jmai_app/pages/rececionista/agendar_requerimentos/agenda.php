<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/head.php") ?>
<?php $page_name = "Requerimentos para Agendamento" ?>

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
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/header.php") ?>
            <div class="app-wrapper d-flex" id="kt_app_wrapper">
                <div class="app-container container-xxl">
                    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                        <div class="d-flex flex-column flex-column-fluid">
                            <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/toolbar.php") ?>
                            <div id="kt_app_content" class="app-content">

                                <div class="row g-6">
                                    <div class="order-2 order-xl-1 col-12 col-xl-8">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div id="schedule" class="h-100 min-h-500px min-h-md-600px min-h-lg-650px"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="calendar-sidebar" class="order-1 order-xl-2 col-12 col-xl-4">
                                        <div data-type="default" class="card">
                                            <div class="card-header card-header-stretch gap-4 flex-wrap min-h-70px">
                                                <h2 class="card-title fw-bold">Calendário</h2>
                                                <div class="card-toolbar">
                                                    <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x nav-stretch fs-6 border-transparent fw-bold">
                                                        <li class="nav-item">
                                                            <a class="nav-link active text-active-primary d-flex align-items-center gap-2" data-bs-toggle="tab" href="#tab-1">
                                                                Eventos
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="card-body p-4 p-lg-6">
                                                <div class="tab-content" id="tab-content">
                                                    <div class="tab-pane fade show active" id="tab-1" role="tabpanel">
                                                        <div class="mb-8" id="external-events">
                                                            <label class="form-label">Eventos Adicionáveis</label>
                                                            <div class="d-flex flex-column gap-2">
                                                                <div class="fc-event text-white bg-primary rounded-1 px-4 py-2" data-event-type="agendamento">
                                                                    <div class="fc-event-main">Agendamento Junta Médica</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="accordion" id="accordion">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="accordion-agendamento-header">
                                                                    <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-agendamento-body" aria-expanded="false" aria-controls="accordion-agendamento-body" disabled>
                                                                        Junta Médica
                                                                    </button>
                                                                </h2>
                                                                <div id="accordion-agendamento-body" class="accordion-collapse collapse show" aria-labelledby="accordion-agendamento-header" data-bs-parent="#accordion">
                                                                    <div class="accordion-body">
                                                                        <?php require_once "componentes_agenda/adicionar.php"; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade" id="tab-2" role="tabpanel">Filtros</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- TAREFA -->
                                        <div data-type="view-agendamento" style="display: none;" class="card">
                                            <div class="card-header card-header-stretch gap-4 flex-wrap min-h-70px">
                                                <h2 class="card-title fw-bold">Junta Médica</h2>
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

                                        <div data-type="edit-agendamento" style="display: none;" class="card">
                                            <div class="card-header card-header-stretch gap-4 flex-wrap min-h-70px">
                                                <h2 class="card-title fw-bold">Editar Junta Médica</h2>
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
                                                <?php //require_once "components/agendamento/edit.php"; 
                                                ?>
                                            </div>

                                            <div class="card-footer d-flex justify-content-xxl-end">
                                                <button type="button" class="btn btn-primary" data-action="submit">
                                                    <span class="indicator-label">Guardar</span>
                                                    <span class="indicator-progress">Aguarde...
                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/footer.php") ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/foo.php") ?>
    <script src="/assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    <script>
        const id_requerimento = <?php echo isset($_GET["id"]) ? ("'" . $_GET["id"] . "'") : "null"; ?>;

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

                // ? Plugins - Select2
                const select2OptionFormat_withAvatar = (item) => {
                    if (!item.id || !item.element.getAttribute("data-avatar")) return item.text;

                    const span = document.createElement("span");
                    const imgUrl = item.element.getAttribute("data-avatar");
                    let template = "";

                    span.classList.add("d-flex", "align-items-center");

                    template += `<img src="${imgUrl}" class="rounded w-25px h-25px me-3" alt="image" style="object-fit: cover;">`;
                    template += item.text;
                    span.innerHTML = template;
                    return $(span);
                };
                const select2OptionFormat_withBullet = (item) => {
                    if (!item.id || !item.element.getAttribute("data-color")) return item.text;

                    const span = document.createElement("span");
                    const color = item.element.getAttribute("data-color");
                    let template = `<div class="bullet h-5px w-10px" style="background-color: ${color};"></div>`;
                    span.classList.add("d-flex", "align-items-center", "gap-3");
                    template += item.text;
                    span.innerHTML = template;
                    return $(span);
                };

                const editTaskDuration = $(`[data-type="edit-agendamento"] [name="duration"]`).flatpickr({
                    enableTime: true,
                    noCalendar: true,
                    time_24hr: true,
                    dateFormat: "H:i",
                    defaultDate: "01:00"
                });
                const editTaskStartDate = $(`[data-type="edit-agendamento"] [name="start-date"]`).flatpickr({
                    enableTime: true,
                    time_24hr: true,
                    dateFormat: "d/m/Y H:i",
                    defaultDate: "01:00",
                    locale: "pt"
                });


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

                    function handleSelect(info) {
                        return;

                        if (calendarParameters.users.length === 0) {
                            toastr.remove();
                            toastr.error("Selecione um médico", {
                                timeOut: 900,
                                preventDuplicates: true
                            });
                            return;
                        } else if (info.start < moment().startOf("day")) {
                            // toastr.error("Não é possível agendar eventos no passado");
                            // return;
                        } else if (calendarAvailabilities.length > 0) {
                            const dayNumber = moment(info.start).day();
                            const startTime = moment(info.start).format("HH:mm");
                            const endTime = moment(info.end).format("HH:mm");

                            const availability = calendarAvailabilities.find((availability) => {
                                return availability.daysOfWeek[0] === dayNumber && availability.startTime <= startTime && availability.endTime >= endTime;
                            });

                            if (!availability) {
                                toastr.error("Não é possível agendar eventos neste horário");
                                return;
                            }
                        }

                        modalAddEventFormDate.setDate(moment(info.start).format("DD/MM/YYYY"));
                        modalAddEventFormStartHour.setDate(moment(info.start).format("HH:mm"));
                        modalAddEventFormEndHour.setDate(moment(info.end).format("HH:mm"));

                        $("#modal-add-event").modal("show");
                    }

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

                    function handleReceive(info) {
                        const id = info.event.id;
                        const date = moment(info.event.start).format("DD/MM/YYYY");
                        const startHour = moment(info.event.start).format("HH:mm");
                        const endHour = moment(info.event.end).format("HH:mm");
                        let formData = null;

                        switch (id) {
                            case "preview-agendamento":
                                formData = new FormData();

                                if ($(accordionTaskEl).find(`[name="hashed_id_requerimento"]`).val() == "") {
                                    calendarBlockUI.release();
                                    calendar.getEventById(id).remove();
                                    calendar.refetchEvents();
                                    toastr.error("Selecione um Requerimento");
                                    return;
                                }

                                if ($(accordionTaskEl).find(`[name="hashed_id_equipa_medica"]`).val() == "") {
                                    calendarBlockUI.release();
                                    calendar.getEventById(id).remove();
                                    calendar.refetchEvents();
                                    toastr.error("Selecione uma Equipa Médica");
                                    return;
                                }

                                formData.append("hashed_id_requerimento", $(accordionTaskEl).find(`[name="hashed_id_requerimento"]`).val());
                                formData.append("hashed_id_equipa_medica", $(accordionTaskEl).find(`[name="hashed_id_equipa_medica"]`).val());
                                formData.append("hashed_id_utilizador", "<?= $_SESSION["hashed_id"] ?>");

                                formData.append("data_agendamento", moment(info.event.start).format("DD/MM/YYYY"));
                                formData.append("hora_agendamento", moment(info.event.end).format("HH:mm:ss"));

                                const data = {};
                                for (const [key, value] of formData.entries()) {
                                    data[key] = value;

                                }

                                Swal.fire({
                                    icon: "question",
                                    title: "Agendar Junta Médica",
                                    text: `Tem a certeza que pretende agendar esta Junta Médica para as ${startHour} do dia ${date}?`,
                                    showCancelButton: true,
                                    buttonsStyling: false,
                                    cancelButtonText: "Não, cancelar!",
                                    confirmButtonText: "Sim, agendar!",
                                    reverseButtons: true,
                                    allowOutsideClick: false,
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-active-primary",
                                        cancelButton: "btn fw-bold btn-active-light-warning",
                                    },
                                    didOpen: () => {
                                        Swal.getConfirmButton().focus();
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                        const request = async (data) => {
                                            const response = await fetch(`${api_base_url}requerimentos/agendar_consulta`, {
                                                method: "POST",
                                                body: JSON.stringify(data),
                                                headers: {
                                                    "Accept": "application/json",
                                                    "content-type": "application/json",
                                                    "Authorization": token
                                                }
                                            });
                                            const result = await response.json();
                                            return result;
                                        };

                                        request(data)
                                            .then((response) => {

                                                if (response.status === "success") {
                                                    calendarBlockUI.block();
                                                    response.messages.map((message) => {
                                                        toastr.success(message);
                                                    });
                                                } else {
                                                    calendarBlockUI.block();
                                                    response.messages.map((message) => {
                                                        toastr.error(message);
                                                    });
                                                }

                                            }).catch((error) => {
                                                console.error(error);
                                            }).finally(() => {
                                                if ($(accordionTaskEl).find(`[name="recurring[checked][]"]`).is(":checked")) {
                                                    $("#wrapper-recurring-agendamento").slideUp();
                                                    $(accordionTaskEl).find(`[name="recurring[checked][]"]`).prop("checked", false);
                                                    $(accordionTaskEl).find(`[name="recurring[range][]"]`).val("7");
                                                    $(accordionTaskEl).find(`[name="recurring[amount][]"]`).val(1);
                                                    $(accordionTaskEl).find(`[name="obs"]`).val("");
                                                }

                                                calendarBlockUI.release();
                                                calendar.getEventById(id).remove();
                                                calendar.refetchEvents();
                                            });

                                    } else {
                                        calendarBlockUI.release();
                                        calendar.getEventById(id).remove();
                                        calendar.refetchEvents();
                                    }
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

                    new FullCalendar.Draggable(containerEl, {
                        itemSelector: ".fc-event",
                        eventData: (eventEl) => {
                            const eventType = eventEl.getAttribute("data-event-type");

                            if (eventType === "agendamento") {
                                const draggableEvent_agendamentoDuration = $(`#accordion-agendamento-body [name="duration"]`);
                                if (!draggableEvent_agendamentoDuration) {
                                    return {
                                        title: "",
                                        duration: "00:00:00"
                                    };
                                }

                                return {
                                    id: "preview-agendamento",
                                    title: "Pré-visualização da Junta Médica",
                                    duration: "01:00:00"
                                };
                            }

                            return {
                                title: "",
                                duration: "00:00:00"
                            };
                        }
                    });

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
                        select: (info) => handleSelect(info),
                        eventClick: (info) => handleClick(info),
                        eventDidMount: (info) => handleDidMount(info),
                        eventReceive: (info) => handleReceive(info),
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

                function initViewTask() {
                    Swal.fire({
                        icon: "warning",
                        title: "Deseja realmente finalizar esta tarefa?",
                        showCancelButton: true,
                        confirmButtonText: "Sim, finalizar",
                        cancelButtonText: "Não, cancelar",
                        reverseButtons: true,
                        customClass: {
                            confirmButton: "btn btn-success",
                            cancelButton: "btn btn-light ml-1"
                        }
                    }).then(async (result) => {
                        if (!result.isConfirmed) return;
                        if (clickedTaskEvent === null) {
                            toastr.error("Nenhuma tarefa selecionada! Por favor, selecione uma tarefa para finalizar.");
                            return;
                        }
                        console.log("Finalizar tarefa");

                        const formData = new FormData();
                        formData.append("action", "finalize-agendamento");
                        formData.append("id", clickedTaskEvent);

                        const response = await fetch("./api.php", {
                                method: "POST",
                                headers: {
                                    "Accept": "application/json"
                                },
                                body: formData
                            })
                            .then((response) => {
                                return response.json();
                            })
                            .then((data) => {
                                if (data.status === "success") toastr.success(data.messages[0]);
                                else toastr.error(data.messages[0]);

                                calendar.refetchEvents();
                                calendarSidebarCloseAll();
                                $(calendarSidebarDefault).show();
                            })
                            .catch((error) => {
                                console.error(error);
                            });
                    });
                }

                function initAccordionTask() {
                    $(accordionTaskEl).find(`[name="recurring[checked][]"]`).on("change", (e) => {
                        const checked = e.currentTarget.checked;
                        if (checked) $("#wrapper-recurring-agendamento").slideDown();
                        else $("#wrapper-recurring-agendamento").slideUp();
                    });

                    console.log($(accordionTaskEl).find('#notifications_repeater'));
                    $(accordionTaskEl).find('#notifications_repeater').repeater({
                        initEmpty: false,

                        defaultValues: {
                            'text-input': 'foo'
                        },

                        show: function() {
                            $(this).slideDown();
                        },

                        hide: function(deleteElement) {
                            $(this).slideUp(deleteElement);
                        }
                    });

                }

                $(calendarSidebarViewTask).find(`[data-action="edit"]`).on("click", () => {
                    calendarSidebarViewTask.hide();
                    calendarSidebarEditTask.show();

                    const agendamento = calendar.getEventById(clickedTaskEvent);
                    $(calendarSidebarEditTask).find(`[name="title"]`).val(agendamento.title);
                    $(calendarSidebarEditTask).find(`[name="obs"]`).val(agendamento.extendedProps.obs);

                    const diff = moment(agendamento.end).diff(moment(agendamento.start));
                    const duration = moment.duration(diff);
                    const hours = duration.hours() > 9 ? duration.hours() : `0${duration.hours()}`;
                    const minutes = duration.minutes() > 9 ? duration.minutes() : `0${duration.minutes()}`;

                    const time = `${hours}:${minutes}`;
                    editTaskDuration.setDate(time, true, "H:i");

                    const startDate = moment(agendamento.start).format("DD/MM/YYYY HH:mm");
                    editTaskStartDate.setDate(startDate, true, "d/m/Y H:i");

                    const users = JSON.parse(agendamento.extendedProps.users);
                    users.map(user => {
                        $(calendarSidebarEditTask).find(`[name="users[]"] option[value="${user.id}"]`).prop("selected", true);
                        $(calendarSidebarEditTask).find(`[name="users[]"] option[value="${user.id}"]`).trigger("change");
                    });

                    const notifications = JSON.parse(agendamento.extendedProps.notifications) || [];
                    console.log(notifications);
                    const notifications_repeater = $(calendarSidebarEditTask).find('#notifications_repeater_edit');
                    console.log(notifications_repeater);
                    notifications_repeater.find("[data-repeater-item]").remove();
                    notifications.map((notification, index) => {
                        $(calendarSidebarEditTask).find('[data-repeater-create]').trigger('click');
                        const notification_repeater = notifications_repeater.find("[data-repeater-item]").last();
                        notification_repeater.find(`[name="notifications[${index}][days]"]`).val(notification.days);

                    });

                });

                $(calendarSidebarViewTask).find(`[data-action="delete"]`).on("click", () => {
                    Swal.fire({
                        icon: "warning",
                        title: "Deseja realmente excluir esta tarefa?",
                        showCancelButton: true,
                        confirmButtonText: "Sim, excluir",
                        cancelButtonText: "Não, cancelar",
                        reverseButtons: true,
                        customClass: {
                            confirmButton: "btn btn-danger",
                            cancelButton: "btn btn-light ml-1"
                        }
                    }).then((result) => {
                        if (!result.isConfirmed) return;
                        if (clickedTaskEvent === null) {
                            toastr.error("Nenhuma tarefa selecionada! Por favor, selecione uma tarefa para excluir.");
                            return;
                        }

                        const formData = new FormData();
                        formData.append("action", "delete-agendamento");
                        formData.append("id", clickedTaskEvent);

                        fetch("./api.php", {
                                method: "POST",
                                headers: {
                                    "Accept": "application/json"
                                },
                                body: formData
                            })
                            .then((response) => {
                                return response.json();
                            })
                            .then((data) => {
                                if (data.status === "success") toastr.success(data.messages[0]);
                                else toastr.error(data.messages[0]);

                                calendarBlockUI.block();
                                calendar.refetchEvents();
                                calendarSidebarCloseAll();
                                $(calendarSidebarDefault).show();
                            })
                            .catch((error) => {
                                console.error(error);
                            })
                            .finally(() => {
                                blockUI.release();
                                button.removeAttribute("data-kt-indicator");
                                button.disabled = false;
                                blockUI.destroy();
                            });
                    });
                });

                $(`[data-type="edit-agendamento"]`).find(`button[data-action="submit"]`).on("click", (e) => {
                    e.preventDefault();

                    const button = e.currentTarget;

                    button.setAttribute("data-kt-indicator", "on");
                    button.disabled = true;

                    const formData = new FormData();
                    const startDate = moment($(`[data-type="edit-agendamento"] [name="start-date"]`).val(), "DD/MM/YYYY HH:mm").format("YYYY-MM-DD HH:mm");
                    const users = $(`[data-type="edit-agendamento"] [name="users[]"]`).val();

                    formData.append("action", "edit-agendamento");
                    formData.append("id", clickedTaskEvent);
                    formData.append("title", $(`[data-type="edit-agendamento"] [name="title"]`).val());
                    formData.append("obs", $(`[data-type="edit-agendamento"] [name="obs"]`).val());
                    formData.append("start-date", startDate);
                    formData.append("end-date", moment(startDate, "YYYY-MM-DD HH:mm").add($(`[data-type="edit-agendamento"] [name="duration"]`).val(), "hours").format("YYYY-MM-DD HH:mm"));
                    users.map(user => formData.append("users[]", user));

                    const notifications = $(`[data-element="notifications_days_edit"]`);
                    notifications.map((index, notification) => {
                        formData.append(`notifications[${index}][days]`, $(notification).val());
                    });

                    const blockUI = new KTBlockUI($(`[data-type="edit-agendamento"]`)[0], {
                        overlayClass: "bg-body",
                        state: "primary",
                        message: "Aguarde..."
                    });

                    blockUI.block();

                    fetch("./api.php", {
                            method: "POST",
                            headers: {
                                "Accept": "application/json"
                            },
                            body: formData
                        })
                        .then((response) => {
                            return response.json();
                        })
                        .then((data) => {
                            if (data.status === true) toastr.success(data.messages[0]);
                            else toastr.error(data.messages[0]);

                            calendarBlockUI.block();
                            calendar.refetchEvents();
                            calendarSidebarCloseAll();
                            $(calendarSidebarDefault).show();
                        })
                        .catch((error) => {
                            console.error(error);
                        })
                        .finally(() => {
                            blockUI.release();
                            button.removeAttribute("data-kt-indicator");
                            button.disabled = false;
                            blockUI.destroy();
                        });
                });

                return {
                    init: () => {
                        initCalendar();

                        // ? Accordions
                        initAccordion();
                        initAccordionTask();

                    }
                };
            })();

            initDocument.init();
        });

        const handleLoadRequerimentos = () => {
            fetch(`${api_base_url}requerimentos/listar_requerimentos`, {
                    method: "POST",
                    headers: {
                        "Accept": "application/json",
                        "content-type": "application/json",
                        "Authorization": token
                    },
                    body: JSON.stringify({
                        "estado": 3
                    })
                })
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    console.log(data);
                    if (data.status === "success") {
                        $(`#accordion-agendamento-body [name="hashed_id_requerimento"]`).empty();
                        $(`#accordion-agendamento-body [name="hashed_id_requerimento"]`).append(`<option></option>`);
                        data.data.map((requerimento) => {
                            $(`#accordion-agendamento-body [name="hashed_id_requerimento"]`).append(`
                                <option value="${requerimento.hashed_id}" ${id_requerimento == requerimento.hashed_id ? "selected" : ""} >${requerimento.numero_requerimento}</option>
                            `);
                        });
                    } else {
                        toastr.error(data.messages[0]);
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        }

        const handleLoadEquipasMedicas = () => {
            fetch(`${api_base_url}equipas_medicas/listar_equipas_medicas`, {
                    method: "GET",
                    headers: {
                        "Accept": "application/json",
                        "content-type": "application/json",
                        "Authorization": token
                    }
                })
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    console.log(data);
                    if (data.status === "success") {
                        $(`#accordion-agendamento-body [name="hashed_id_equipa_medica"]`).empty();
                        $(`#accordion-agendamento-body [name="hashed_id_equipa_medica"]`).append(`<option></option>`);
                        data.data.map((equipa_medica) => {
                            $(`#accordion-agendamento-body [name="hashed_id_equipa_medica"]`).append(`
                                <option value="${equipa_medica.hashed_id}">${equipa_medica.nome}</option>
                            `);
                        });
                    } else {
                        toastr.error(data.messages[0]);
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        }

        window.addEventListener("DOMContentLoaded", () => {
            handleLoadRequerimentos();
            handleLoadEquipasMedicas();
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const selectionWithAvatar = (item) => {
                if (!item.id || !item.element.getAttribute("data-avatar")) return item.text;

                const span = document.createElement("span");
                const imgUrl = item.element.getAttribute("data-avatar");
                let template = "";

                span.classList.add("d-flex", "align-items-center", "fs-7");

                template += `<img src="${imgUrl}" class="rounded w-20px h-20px ms-3 me-2" alt="image" style="object-fit: cover;">`;
                template += item.text;
                span.innerHTML = template;
                console.log(span);
                return $(span);
            };

            const resultWithAvatar = (item) => {
                if (!item.id || !item.element.getAttribute("data-avatar")) return item.text;

                const span = document.createElement("span");
                const imgUrl = item.element.getAttribute("data-avatar");
                let template = "";

                span.classList.add("d-flex", "align-items-center");

                template += `<img src="${imgUrl}" class="rounded w-25px h-25px me-3" alt="image" style="object-fit: cover;">`;
                template += item.text;
                span.innerHTML = template;
                console.log(span);
                return $(span);
            };

            $(`#accordion-agendamento-body [name="users[]"]`).select2({
                language: "pt",
                templateSelection: selectionWithAvatar,
                templateResult: resultWithAvatar,
                closeOnSelect: false,
                scrollAfterSelect: false,
                placeholder: "Selecione um Utilizador",
                allowClear: false,
                width: "100%"
            });

            /* $(`#accordion-agendamento-body [name="duration"]`).flatpickr({
                enableTime: true,
                noCalendar: true,
                time_24hr: true,
                dateFormat: "H:i",
                defaultDate: "01:00",
                locale: "pt"
            }); */

            $(`[data-type="edit-agendamento"] [name="users[]"]`).select2({
                language: "pt",
                templateSelection: selectionWithAvatar,
                templateResult: resultWithAvatar,
                closeOnSelect: false,
                scrollAfterSelect: false,
                placeholder: "Selecione um Utilizador",
                allowClear: false,
                width: "100%"
            });

            $('#notifications_repeater_edit').repeater({
                initEmpty: false,

                defaultValues: {
                    'text-input': 'foo'
                },

                show: function() {
                    $(this).slideDown();
                },

                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            });
        });
    </script>
</body>