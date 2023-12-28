<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/head.php") ?>
<?php $page_name = "Requerimentos para Agendamento" ?>

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

                                <!-- Conteudo AQUI! -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-md-between flex-wrap mb-5 gap-4">
                                            <div class="d-flex align-items-center position-relative my-1 mb-2 mb-md-0">
                                                <span class="svg-icon svg-icon-1 position-absolute ms-5">
                                                    <i class="ki-outline ki-magnifier fs-2"></i>
                                                </span>
                                                <input type="text" data-datatable-action="search" class="form-control form-control-solid w-250px ps-15" placeholder="Pesquisar...">
                                            </div>

                                            <div class="d-flex flex-column flex-sm-row align-items-center justify-content-md-end gap-3">
                                                <button type="button" class="btn btn-icon btn-active-light-primary lh-1" data-datatable-action="sync" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" title="Sincronizar tabela">
                                                    <i class="ki-outline ki-arrows-circle fs-2"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table id="datatable" class="table align-middle gs-0 gy-4">
                                                <thead>
                                                    <tr class="fw-bold text-muted bg-light">
                                                        <th class="ps-4 fs-6 min-w-80px rounded-start" data-priority="1">Número Requerimento</th>
                                                        <th class="ps-4 fs-6 min-w-200px" data-priority="2">Nome Utente</th>
                                                        <th class="ps-4 fs-6 min-w-100px" data-priority="3">Número Utente</th>
                                                        <th class="ps-4 fs-6 min-w-150px" data-priority="4">Tipo Requerimento</th>
                                                        <th class="ps-4 fs-6 min-w-100px" data-priority="5">Estado</th>
                                                        <th class="ps-4 fs-6 min-w-100px" data-priority="6">Data Pedido</th>
                                                        <th class="pe-4 fs-6 min-w-25px text-sm-end rounded-end" data-priority="7">Agendar</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fecha Conteudo AQUI! -->

                            </div>
                        </div>
                        <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/footer.php") ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para fazer o agendamento da junta médica -->
    <div class="modal fade" id="agendar_junta" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header" id="modal-agendar-junta-header">
                    <h2 class="fw-bold">Agendar Junta Médica</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times fs-1"></i>
                    </div>
                </div>

                <div class="modal-body mx-5 mx-xl-15 my-7">
                    <form id="modal-agendar-junta-form" class="form" action="#">
                        <div class="d-flex flex-column me-n7 pe-7" id="modal-agendar-junta-form-scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#modal-agendar-junta-header" data-kt-scroll-wrappers="#modal-agendar-junta-form-scroll" data-kt-scroll-offset="350px" style="max-height: 91px;">
                            <div class="row g-6">
                                <div class="col-12">
                                    <label class="col-lg-12 col-form-label required fw-semibold fs-6">Selecione a Equipa Médica:</label>
                                    <select class="form-select form-select-solid form-control-lg" name="equipa" data-control="select2" data-close-on-select="false" data-placeholder="Selecione a Equipa" data-allow-clear="true">
                                        <option></option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="col-lg-12 col-form-label required required fw-semibold fs-6">Data da Consulta</label>
                                    <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                        <input class="form-control form-control-solid" name="data_consulta" autocomplete="off" placeholder="Selecione uma Data para a Consulta" id="data_consulta" />
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="col-lg-12 col-form-label required required fw-semibold fs-6">Hora da Consulta</label>
                                    <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                        <input class="form-control form-control-solid" name="kt_datepicker_8" autocomplete="off" placeholder="Selecione uma hora para a Consulta" id="kt_datepicker_8" />
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" name="data-kt-indicator" class="btn btn-primary" data-modal-action="submit">
                                <span class="indicator-label">Agendar</span>
                                <span class="indicator-progress">Aguarde...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/foo.php") ?>

    <script>
        var hashed_id_requerimento = null;

        var datatableServerSide = (function() {
            var table
            var dt

            var initDatatable = () => {
                dt = $("#datatable").DataTable({
                    language: {
                        url: "https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-PT.json",
                    },
                    searchDelay: 1000,
                    processing: true,
                    serverSide: false,
                    responsive: true,
                    order: [
                        [5, "desc"]
                    ],
                    lengthMenu: [5, 10, 25, 50, 75, 100],
                    stateSave: false,
                    ajax: {
                        url: "http://localhost:8888/api/requerimentos/listar",
                        contentType: "application/json",
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization', token);
                        },
                        data: () => {
                            return JSON.stringify({
                                'estado': 3
                            });
                        },
                        type: "POST",
                    },
                    columns: [{
                            data: "numero_requerimento"
                        },
                        {
                            data: "informacao_utente.nome"
                        },
                        {
                            data: "informacao_utente.numero_utente"
                        },
                        {
                            data: "texto_tipo_requerimento"
                        },
                        {
                            data: "texto_estado"
                        },
                        {
                            data: "data_criacao"
                        },
                        {
                            data: null
                        }
                    ],
                    columnDefs: [{
                            targets: 0,
                            orderable: true,
                            render: (data, type, row) => {
                                return `
                            <div class="d-inline-flex align-items-center ms-4">                                
                                <div class="d-flex justify-content-center flex-column">
                                    <span class="text-dark fw-bold text-hover-primary mb-1 fs-6 lh-sm">${row.numero_requerimento}</span>
                                </div>
                            </div>
                        `
                            },
                        },
                        {
                            targets: 1,
                            orderable: false,
                            render: (data, type, row) => {
                                return `
									<div class="d-inline-flex align-items-center">                                
                                <div class="d-flex justify-content-center flex-column">
                                    <span class="text-dark fw-bold text-hover-primary mb-1 fs-6 lh-sm">${row.informacao_utente.nome}</span>
                                </div>
                            </div>
                        `
                            }
                        },
                        {
                            targets: 2,
                            orderable: false,
                            render: (data, type, row) => {
                                return `
									<div class="d-inline-flex align-items-center">                                
                                <div class="d-flex justify-content-center flex-column">
                                    <span class="text-dark fw-bold text-hover-primary mb-1 fs-6 lh-sm">${row.informacao_utente.numero_utente}</span>
                                </div>
                            </div>
                        `
                            }
                        },
                        {
                            targets: 3,
                            orderable: false,
                            render: (data, type, row) => {
                                return `
									<div class="d-inline-flex align-items-center">                                
                                <div class="d-flex justify-content-center flex-column">
                                    <span class="text-dark fw-bold text-hover-primary mb-1 fs-6 lh-sm">${row.texto_tipo_requerimento}</span>
                                </div>
                            </div>
                        `
                            }
                        },
                        {
                            targets: 4,
                            orderable: true,
                            render: (data, type, row) => {
                                if (row.estado === 0) {
                                    return `
									<div class="d-inline-flex align-items-center">                                
										<div class="d-flex justify-content-center flex-column">
											<span class="badge badge-info">Pendente</span>
										</div>
									</div>
								`
                                } else if (row.estado === 1) {
                                    return `
                                    <div class="d-inline-flex align-items-center">                                
										<div class="d-flex justify-content-center flex-column">
											<span class="badge badge-warning">Aguarda Avaliação</span>
										</div>
									</div>
								`
                                } else if (row.estado === 2) {
                                    return `
                                    <div class="d-inline-flex align-items-center">                                
										<div class="d-flex justify-content-center flex-column">
											<span class="badge badge-light-primary">Avaliado</span>
										</div>
									</div>
								`
                                } else if (row.estado === 3) {
                                    return `
                                    <div class="d-inline-flex align-items-center">                                
										<div class="d-flex justify-content-center flex-column">
											<span class="badge badge-primary">A Agendar</span>
										</div>
									</div>
								`
                                } else if (row.estado === 4) {
                                    return `
                                    <div class="d-inline-flex align-items-center">                                
										<div class="d-flex justify-content-center flex-column">
											<span class="badge badge-success">Agendado</span>
										</div>
									</div>
								`
                                } else if (row.estado === 5) {
                                    return `
                                    <div class="d-inline-flex align-items-center">                                
										<div class="d-flex justify-content-center flex-column">
											<span class="badge badge-dark">Inválido</span>
										</div>
									</div>
								`
                                } else if (row.estado === 6) {
                                    return `
                                    <div class="d-inline-flex align-items-center">                                
										<div class="d-flex justify-content-center flex-column">
											<span class="badge badge-danger">Cancelado</span>
										</div>
									</div>
								`
                                }
                            },
                        },
                        {
                            targets: 5,
                            orderable: true,
                            render: (data, type, row) => {
                                return `
									<div class="d-inline-flex align-items-center">                                
										<div class="d-flex justify-content-center flex-column">
											<span class="text-dark fw-bold text-hover-primary mb-1 fs-6 lh-sm">${row.data_criacao}</span>
										</div>
									</div>
								`;
                            },
                        },
                        {
                            targets: -1,
                            orderable: false,
                            className: "text-sm-end",
                            render: (data, type, row) => {
                                return `
									<div>
                                        <a href="agenda?id=${row.hashed_id}" class="btn btn-bg-light btn-color-primary btn-active-light-primary rounded me-1"><i class="ki-outline ki-calendar-add fs-2"></i> Agenda</a>
                                        <button type="button" data-id="${row.hashed_id}" data-datatable-action="submit" class="btn btn-icon btn-bg-light btn-color-primary btn-active-light-primary rounded w-35px h-35px me-1"><i class="ki-outline ki-calendar-add fs-2"></i></button>
									</div>
								`
                            },
                        },
                    ],
                })

                table = dt.$

                dt.on("draw", () => {})
            }

            var handleSyncDatatable = () => {
                const syncButton = document.querySelector(`[data-datatable-action="sync"]`)
                if (!syncButton) {
                    toastr.error("Não foi possível encontrar o botão de sincronização.")
                    return
                }

                syncButton.addEventListener("click", (e) => {
                    e.preventDefault()
                    dt.ajax.reload()
                })
            }

            var handleSearchDatatable = () => {
                const filterSearch = document.querySelector(`[data-datatable-action="search"]`)
                filterSearch.addEventListener("keyup", (e) => dt.search(e.target.value).draw())
            }


            var handleAgendarJunta = () => {
                const agendarJuntaButtons = document.querySelectorAll(`[data-datatable-action="submit"]`)

                $("#datatable").on("click", "[data-datatable-action='submit']", (e) => {
                    e.preventDefault()
                    const button = e.currentTarget
                    const parent = button.closest("tr")
                    const id = button.getAttribute("data-id")
                    hashed_id_requerimento = id;

                    $("#agendar_junta").modal("show")

                })
            }

            function handleCarregarEquipas() {
                const submitButton = document.querySelector(`[data-modal-action="submit"]`)
                submitButton.setAttribute("data-kt-indicator", "on");

                const requestOptions = {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": "<?php echo $_SESSION['token'] ?>"
                    },
                };

                fetch(`${api_base_url}equipas_medicas/listar_equipas_medicas`, requestOptions)
                    .then((response) => response.json())
                    .then((data) => {

                        if (data.status === "success") {
                            data.data.forEach((element) => {
                                var option = document.createElement("option");
                                option.value = element.hashed_id;
                                option.text = element.nome;
                                $("select[name='equipa']").append(option);
                            });

                            //reinit select2
                            $("select[name='equipa']").select2({
                                placeholder: "Selecione a Equipa",
                                allowClear: true,
                            });

                            submitButton.removeAttribute("data-kt-indicator");
                            submitButton.disabled = false;
                        } else {
                            toastr.error(data.messages[0], "Erro!");
                        }
                    })
                    .catch((error) => {
                        toastr.error(error, "Erro!");
                    })
                    .finally(() => {

                    });
            }

            return {
                init: () => {
                    initDatatable()
                    handleSyncDatatable()
                    handleSearchDatatable()
                    handleAgendarJunta()
                    handleCarregarEquipas()
                },
            }
        })()

        window.addEventListener("DOMContentLoaded", () => {
            datatableServerSide.init()
        })



        $("#modal-agendar-junta-form").on("submit", function(e) {
            e.preventDefault()

            const button = document.querySelector(`[data-modal-action="submit"]`)
            const buttonText = button.querySelector(".indicator-label")
            const buttonProgress = button.querySelector(".indicator-progress")

            button.setAttribute("disabled", "disabled")
            buttonText.innerHTML = "Aguarde..."
            buttonProgress.classList.remove("d-none")

            const equipa = document.querySelector(`[name="equipa"]`).value
            const data_consulta = document.querySelector(`[name="data_consulta"]`).value
            const hora_consulta = document.querySelector(`[name="kt_datepicker_8"]`).value

            const options = {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "<?php echo $_SESSION["token"] ?>",
                },
                body: JSON.stringify({
                    "hashed_id_equipa_medica": equipa,
                    "data_agendamento": data_consulta,
                    "hora_agendamento": hora_consulta,
                    "hashed_id_requerimento": hashed_id_requerimento,
                    "hashed_id_utilizador": "<?php echo $_SESSION["hashed_id"] ?>"

                })
            }

            fetch(`${api_base_url}requerimentos/agendar_consulta`, options)
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "success") {
                        Swal.fire({
                            text: data.messages[0],
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, fechar",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            },
                        }).then(() => {
                            window.location.reload();
                            hashed_id_requerimento = null;
                            $("#agendar_junta").modal("hide");
                            $("#modal-agendar-junta-form").trigger("reset");
                            

                        })
                    } else {
                        Swal.fire({
                            text: data.messages[0],
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, fechar",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            },
                        })
                    }
                })
                .catch((error) => {
                    console.error(error)
                })
        })
    </script>

    <script>
        flatpickr("#data_consulta", {
            allowInput: true,
            minDate: "today",
        });

        $("#kt_datepicker_8").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
        });
    </script>

</body>