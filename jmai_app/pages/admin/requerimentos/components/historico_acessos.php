<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Informação do Histórico de Acessos ao Requerimento</h3>
        </div>
    </div>

    <div class="card-body p-9">
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
                        <th class="ps-4 fs-6 min-w-200px rounded-start" data-priority="1">Nome Utilizador</th>
                        <th class="ps-4 fs-6 min-w-200px" data-priority="2">Cargo Utilizador</th>
                        <th class="pe-4 fs-6 min-w-100px text-sm-end rounded-end" data-priority="7">Data / Hora Acesso</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

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
                    [2, "desc"]
                ],
                lengthMenu: [10, 25, 50, 75, 100],
                stateSave: false,
                ajax: {
                    url: "http://localhost:8888/api/requerimentos/acessos/listar?hashed_id_requerimento=<?php echo $hashed_id_requerimento ?>",
                    contentType: "application/json",
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization', token);
                    },
                    type: "GET",
                },
                columns: [{
                        data: "nome_utilizador"
                    },
                    {
                        data: "texto_cargo_utilizador"
                    },
                    {
                        data: "data_hora_acesso"
                    }
                ],
                columnDefs: [{
                        targets: 0,
                        orderable: true,
                        render: (data, type, row) => {
                            return `
                            <div class="d-inline-flex align-items-center ms-4">                                
                                <div class="d-flex justify-content-center flex-column">
                                    <span class="text-dark fw-bold text-hover-primary mb-1 fs-6 lh-sm">${row.nome_utilizador}</span>
                                </div>
                            </div>
                        `
                        },
                    },
                    {
                        targets: 1,
                        orderable: false,
                        render: (data, type, row) => {
                            if (row.cargo_utilizador === 0) {
                                return `
									<div class="d-inline-flex align-items-center ms-10">                                
										<div class="d-flex justify-content-center flex-column">
											<span class="badge badge-danger">Administrador</span>
										</div>
									</div>
								`
                            } else if (row.cargo_utilizador === 1) {
                                return `
                                    <div class="d-inline-flex align-items-center ms-10">                                
										<div class="d-flex justify-content-center flex-column">
											<span class="badge badge-warning">Médico</span>
										</div>
									</div>
								`
                            } else if (row.cargo_utilizador === 2) {
                                return `
                                    <div class="d-inline-flex align-items-center ms-10">                                
										<div class="d-flex justify-content-center flex-column">
											<span class="badge badge-success">Rececionista</span>
										</div>
									</div>
								`
                            }
                        }
                    },
                    {
                        targets: 2,
                        orderable: true,
                        className: "text-sm-end",
                        render: (data, type, row) => {
                            return `
									<div class="d-inline-flex align-items-center me-4">                                
                                <div class="d-flex justify-content-center flex-column">
                                    <span class="badge badge-outline badge-dark">${row.data_hora_acesso}</span>
                                </div>
                            </div>
                        `
                        }
                    }
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

        return {
            init: () => {
                initDatatable()
                handleSyncDatatable()
                handleSearchDatatable()
            },
        }
    })()

    window.addEventListener("DOMContentLoaded", () => {
        datatableServerSide.init()
    })
</script>