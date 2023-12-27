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
    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/foo.php") ?>

    <script>
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
										<a class="btn btn-icon btn-bg-light btn-color-primary btn-active-light-primary rounded w-35px h-35px me-1"><i class="ki-outline ki-calendar-add fs-2"></i></a>
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

            var handleDeleteRows = () => {
                const deleteButtons = document.querySelectorAll(`[data-datatable-action="delete-row"]`)

                $("#datatable").on("click", "[data-datatable-action='delete-row']", (e) => {
                    e.preventDefault()
                    const button = e.currentTarget
                    const parent = button.closest("tr")
                    const name = button.getAttribute("data-name")

                    Swal.fire({
                        icon: "warning",
                        title: "Desativar Administrador - " + name,
                        text: "Tem a certeza que deseja desativar o Administrador - " + name + "?",
                        showCancelButton: true,
                        buttonsStyling: false,
                        cancelButtonText: "Não, cancelar",
                        confirmButtonText: "Sim, desativar!",
                        reverseButtons: true,
                        allowOutsideClick: false,
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton: "btn fw-bold btn-active-light-warning",
                        },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const id = button.getAttribute("data-id");

                            const options = {
                                method: "PUT",
                                headers: {
                                    "Content-Type": "application/json",
                                    "Authorization": "<?php echo $_SESSION["token"] ?>",
                                },
                                body: JSON.stringify({
                                    "cargo": 0
                                })
                            }

                            fetch(`${api_base_url}utilizadores/desativar/${id}`, options)
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
                                            dt.ajax.reload()
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
                        }
                    })
                })
            }

            var handleActivateRows = () => {
                const activateButtons = document.querySelectorAll(`[data-datatable-action="activate-row"]`)

                $("#datatable").on("click", "[data-datatable-action='activate-row']", (e) => {
                    e.preventDefault()
                    const button = e.currentTarget
                    const parent = button.closest("tr")
                    const name = button.getAttribute("data-name")

                    Swal.fire({
                        icon: "warning",
                        title: "Ativar Administrador - " + name,
                        text: "Tem a certeza que deseja ativar o Administrador - " + name + "?",
                        showCancelButton: true,
                        buttonsStyling: false,
                        cancelButtonText: "Não, cancelar",
                        confirmButtonText: "Sim, ativar!",
                        reverseButtons: true,
                        allowOutsideClick: false,
                        customClass: {
                            confirmButton: "btn fw-bold btn-success",
                            cancelButton: "btn fw-bold btn-active-light-warning",
                        },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const id = button.getAttribute("data-id");

                            const options = {
                                method: "PUT",
                                headers: {
                                    "Content-Type": "application/json",
                                    "Authorization": "<?php echo $_SESSION["token"] ?>",
                                },
                                body: JSON.stringify({
                                    "cargo": 0
                                })
                            }

                            fetch(`${api_base_url}utilizadores/ativar/${id}`, options)
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
                                            dt.ajax.reload()
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
                        }
                    })
                })
            }

            return {
                init: () => {
                    initDatatable()
                    handleSyncDatatable()
                    handleSearchDatatable()
                    handleDeleteRows()
                    handleActivateRows()
                },
            }
        })()

        window.addEventListener("DOMContentLoaded", () => {
            datatableServerSide.init()
        })
    </script>
</body>