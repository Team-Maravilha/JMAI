<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/head.php") ?>
<?php $page_name = "Todos os Requerimentos" ?>

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


                                                <!-- Filtros Tabela -->
                                                <button type="button" class="btn btn-light-warning d-flex align-items-center lh-1 gap-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                    <i class="ki-outline ki-filter fs-2 p-0 m-0"></i>
                                                    Filtros
                                                </button>
                                                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" id="toolbar-filter">
                                                    <div class="px-7 py-5">
                                                        <div class="fs-4 text-dark fw-bold">Opções de Filtro</div>
                                                    </div>

                                                    <div class="separator border-gray-200"></div>

                                                    <div class="px-7 py-5">
                                                        <div class="mb-0">
                                                            <label class="form-label fs-5 fw-semibold mb-3">Estado Requerimento</label>

                                                            <select class="form-select form-select-solid" id="estado" data-datatable-filter="estado">
                                                                <option value="all" selected>Todos</option>
                                                                <option value="0" data-color="#7239ea">Pendente</option>
                                                                <option value="1" data-color="#50cd89">Aguarda Avaliação</option>
                                                                <option value="2" data-color="#ffc700">Avaliado</option>
                                                                <option value="3" data-color="#181C32">A Agendar</option>
                                                                <option value="4" data-color="#f1416c">Agendado</option>
                                                                <option value="5" data-color="#ff407b">Inválido</option>
                                                                <option value="6" data-color="#ff5e3a">Cancelado</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="px-7 py-5">
                                                        <div class="mb-0">
                                                            <label class="form-label fs-5 fw-semibold mb-3">Tipo Requerimento</label>

                                                            <select class="form-select form-select-solid" id="tipo" data-datatable-filter="tipo">
                                                                <option value="all" selected>Todos</option>
                                                                <option value="0">Multiuso</option>
                                                                <option value="1">Importação de Veículo</option>
                                                            </select>
                                                        </div>
                                                    </div>



                                                    <div class="separator border-gray-200"></div>

                                                    <div class="px-7 py-5">
                                                        <div class="d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-light-primary" data-kt-menu-dismiss="true" data-datatable-action="filter">Aplicar</button>
                                                        </div>
                                                    </div>
                                                </div>

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
                                                        <th class="pe-4 fs-6 min-w-25px text-sm-end rounded-end" data-priority="7">Ações</th>
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
        const select2OptionFormat = (item) => {
            if (!item.id) return item.text;
            const color = item.element.getAttribute("data-color");
            if (!color) return item.text;

            const span = document.createElement("span");
            let template = "";

            span.setAttribute("class", "d-flex align-items-center");

            template += `<span class="badge text-white" style="background-color: ${color};">${item.text}</span>`;

            span.innerHTML = template;
            return $(span);
        };

        window.addEventListener("DOMContentLoaded", () => {
            $("#tipo").select2({
                placeholder: "Selecione um tipo",
                allowClear: false,
                width: "100%",
                templateSelection: select2OptionFormat,
                templateResult: select2OptionFormat
            });

            $("#estado").select2({
                placeholder: "Selecione um estado",
                allowClear: false,
                width: "100%",
                templateSelection: select2OptionFormat,
                templateResult: select2OptionFormat
            });
        });
    </script>
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
                    lengthMenu: [10, 25, 50, 75, 100],
                    stateSave: false,
                    ajax: {
                        url: "http://localhost:8888/api/requerimentos/listar",
                        contentType: "application/json",
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization', token);
                        },
                        data: () => {
                            return JSON.stringify({
                                'estado': document.querySelector('select[data-datatable-filter="estado"]').value === "all" ? null : document.querySelector('select[data-datatable-filter="estado"]').value,
                                'tipo_requerimento': document.querySelector('select[data-datatable-filter="tipo"]').value === "all" ? null : document.querySelector('select[data-datatable-filter="tipo"]').value
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
                                        ${
                                            row.estado >= 2 && row.estado <= 4 ?
                                            `
                                                <button type="button" class="btn btn-icon btn-bg-light btn-color-success btn-active-light-success rounded w-35px h-35px me-1" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" title="Ver Avaliação" data-id="${row.hashed_id}" data-name="${row.numero_requerimento}" data-datatable-action="ver-pdf-avaliacao">
                                                    <i class="fs-2 ki-duotone ki-document"><span class="path1"></span><span class="path2"></span></i>
                                                </button>
                                            ` : ``
                                        }
										<a href="ver?id=${row.hashed_id}" class="btn btn-icon btn-bg-light btn-color-info btn-active-light-info rounded w-35px h-35px me-1"><i class="ki-outline ki-information-2 fs-2"></i></a>
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

            var handlePreviewPDF = () => {
                const buttons = document.querySelectorAll(`[data-datatable-action="ver-pdf-avaliacao"]`);
                var toaster_shown_document = false;
                $("#datatable").on("click", "[data-datatable-action='ver-pdf-avaliacao']", (e) => {
                    e.preventDefault()
                    const button = e.currentTarget
                    const parent = button.closest("tr")
                    const id = button.getAttribute("data-id")
                    const name = button.getAttribute("data-name")

                    Swal.fire({
                        icon: "warning",
                        title: "Ver Avaliação - " + name,
                        text: "Tem a certeza que deseja ver a avaliação do requerimento - " + name + "?",
                        showCancelButton: true,
                        buttonsStyling: false,
                        cancelButtonText: "Não, cancelar",
                        confirmButtonText: "Sim, ver!",
                        reverseButtons: true,
                        allowOutsideClick: false,
                        customClass: {
                            confirmButton: "btn fw-bold btn-success",
                            cancelButton: "btn fw-bold btn-active-light-warning",
                        },
                    }).then((result) => {
                        if (result.isConfirmed) {

                            if (toaster_shown_document) {
                                toastr.clear(toaster_shown_document);
                                toaster_shown_document = false;
                            }

                            toaster_shown_document = toastr.info("Aguarde enquanto o documento é gerado...", "Aguarde", {
                                timeOut: 0,
                                extendedTimeOut: 0,
                                closeButton: false,
                                tapToDismiss: false,
                                progressBar: true,
                                onHidden: function() {
                                    toaster_shown_document = false;
                                }
                            });

                            const options = {
                                method: "GET",
                                headers: {
                                    "Content-Type": "application/pdf",
                                }
                            };

                            fetch(`/api/controllers/gerar_pdf_avaliacao?id_requerimento=${id}`, options)
                                .then((response) => response.blob())
                                .then((blob) => {
                                    var newBlob = new Blob([blob], {
                                        type: "application/pdf"
                                    });
                                    const data = window.URL.createObjectURL(newBlob);

                                    // Open the PDF in a new tab
                                    //window.open(data, '_blank');

                                    // Create an <iframe> element
                                    const iframe = document.createElement('iframe');
                                    iframe.src = data;
                                    iframe.style.display = 'none';

                                    // Append the <iframe> element to the document body
                                    document.body.appendChild(iframe);

                                    // Wait for the PDF to load in the <iframe>
                                    iframe.onload = () => {
                                        // Open the print dialog
                                        iframe.contentWindow.print();
                                        setTimeout(function() {
                                            // For Firefox it is necessary to delay revoking the ObjectURL
                                            URL.revokeObjectURL(data);
                                            //document.body.removeChild(iframe);
                                        }, 100);

                                    };

                                    toastr.clear(toaster_shown_document);

                                })
                                .catch((error) => {
                                    console.error(error)
                                })


                        }
                    })
                })

            }

            var handleFilterDatatable = () => {
                const filterButton = document.querySelector(`[data-datatable-action="filter"]`);

                filterButton.addEventListener("click", () => {
                    dt.ajax.reload()
                });
            };

            return {
                init: () => {
                    initDatatable()
                    handleSyncDatatable()
                    handleSearchDatatable()
                    handleDeleteRows()
                    handleActivateRows()
                    handlePreviewPDF()
                    handleFilterDatatable()
                },
            }
        })()

        window.addEventListener("DOMContentLoaded", () => {
            datatableServerSide.init()
        })
    </script>
</body>