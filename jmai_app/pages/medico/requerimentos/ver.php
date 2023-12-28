<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/head.php") ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/api/api.php") ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/api/api_rnu.php") ?>
<?php
$api = new Api();
$api_rnu = new ApiRNU();
if (isset($_GET["id"])) {
    $hashed_id = $_GET["id"];
} else {
    header("Location: pages/rececionista/requerimentos/lista");
}
$requerimento = $api->fetch("requerimentos/ver", null, $hashed_id);
$info_requerimento = $requerimento["response"]["data"];
$hashed_id_requerimento = $info_requerimento["hashed_id"];
$numero_utente = $info_requerimento["informacao_utente"]["numero_utente"];

$patient_info = $api_rnu->fetch("patients/num_utente", null, $numero_utente);
if ($patient_info["status"] == false) {
    $patient_info_data = null;
} else {
    $patient_info_data = $patient_info["response"][0];
}

$get_tab = isset($_GET["tab"]) ? $_GET["tab"] : "requerimento_tab_2";

if($get_tab === "requerimento_tab_2"){
    $registar_acesso = $api->post("requerimentos/acessos/registar", ["hashed_id_requerimento" => $hashed_id_requerimento, "hashed_id_utilizador" => $id_user], null);
}
?>
<?php $page_name = "Informação Requerimento " . "(" . $info_requerimento["numero_requerimento"] . ")" . " - " . $info_requerimento["informacao_utente"]["nome"]  ?>

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
                                <div class="card mb-5 mb-xl-10">
                                    <div class="card-body pt-9 pb-0">
                                        <div class="d-flex flex-wrap flex-sm-nowrap">

                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                                    <div class="d-flex flex-column">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <a class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"><?php echo $info_requerimento["informacao_utente"]["nome"] ?></a><a class="text-gray-900 text-hover-primary fs-3 ms-2">Nº Utente:<?php echo $info_requerimento["informacao_utente"]["numero_utente"] ?></a>
                                                        </div>

                                                        <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                                            <a class="d-flex align-items-center text-gray-400 me-5 mb-2">
                                                                <i class="ki-outline ki-sms fs-4 me-1"></i><?php echo $info_requerimento["informacao_utente"]["email_autenticacao"] ?></a>
                                                            <a class="d-flex align-items-center text-gray-400 me-5 mb-2">
                                                                <i class="ki-outline ki-phone fs-4 me-1"></i><?php echo $info_requerimento["numero_telemovel"] ?></a>
                                                            <a class="d-flex align-items-center text-gray-400 mb-2">
                                                                <i class="ki-outline ki-information-2 fs-4 me-1"></i>
                                                                <?php echo $info_requerimento["data_criacao"] ?>
                                                        </div>

                                                        <!-- Numero Requrimento -->
                                                        <span class="badge badge-warning me-2"><?php echo $info_requerimento["numero_requerimento"] ?></span>

                                                        <!-- Estado Requerimento -->
                                                        <?php if ($info_requerimento["estado"] === 0) { ?>
                                                            <span class="badge badge-info me-2">Pendente</span>
                                                        <?php } else if ($info_requerimento["estado"] === 1) { ?>
                                                            <span class="badge badge-warning me-2">Aguarda Avaliação</span>
                                                        <?php } else if ($info_requerimento["estado"] === 2) { ?>
                                                            <span class="badge badge-light-primary me-2">Avaliado</span>
                                                        <?php } else if ($info_requerimento["estado"] === 3) { ?>
                                                            <span class="badge badge-primary me-2">A Agendar</span>
                                                        <?php } else if ($info_requerimento["estado"] === 4) { ?>
                                                            <span class="badge badge-success me-2">Agendado</span>
                                                        <?php } else if ($info_requerimento["estado"] === 5) { ?>
                                                            <span class="badge badge-dark me-2">Inválido</span>
                                                        <?php } else if ($info_requerimento["estado"] === 6) { ?>
                                                            <span class="badge badge-danger me-2">Cancelado</span>
                                                        <?php } else { ?>
                                                            <span class="badge badge-light-dark me-2">Sem Informação Estado</span>
                                                        <?php } ?>

                                                        <!-- Tipo Requerimento -->
                                                        <?php if ($info_requerimento["tipo_requerimento"] === 0) { ?>
                                                            <span class="badge badge-primary me-2">Multiuso</span>
                                                        <?php } else if ($info_requerimento["tipo_requerimento"] === 1) { ?>
                                                            <span class="badge badge-primary me-2">Importação de Veículo</span>
                                                        <?php } else { ?>
                                                            <span class="badge badge-light-dark me-2">Sem Informação Tipo</span>
                                                        <?php } ?>

                                                        <!-- Primeiro / ReAvaliação Requerimento -->
                                                        <?php if ($info_requerimento["primeira_submissao"] === 1) { ?>
                                                            <span class="badge badge-success me-2">Primeira Submissão</span>
                                                        <?php } else if ($info_requerimento["primeira_submissao"] === 0) { ?>
                                                            <span class="badge badge-danger me-2">ReAvaliação -<span class="ms-1"><?php echo "Data Última Submissão: " . $info_requerimento["data_submissao_anterior"] ?></span></span>
                                                        <?php } else { ?>
                                                            <span class="badge badge-light-dark me-2">Sem Informação</span>
                                                        <?php } ?>

                                                    </div>

                                                    <div class="d-flex my-4">

                                                        <a class="btn btn-sm btn-warning me-3" data-bs-toggle="modal" data-bs-target="#avaliar-requerimento">Avaliar Requerimento</a>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">

                                            <li class="nav-item mt-2">
                                                <a class="nav-link text-active-primary ms-0 me-10 py-5 <?php if ($get_tab === "requerimento_tab_1") echo "active"; ?>" href="?id=<?php echo $hashed_id; ?>&tab=requerimento_tab_1">Informação do Utente - RNU</a>
                                            </li>

                                            <li class="nav-item mt-2">
                                                <a class="nav-link text-active-primary ms-0 me-10 py-5 <?php if ($get_tab === "requerimento_tab_2") echo "active"; ?>" href="?id=<?php echo $hashed_id; ?>&tab=requerimento_tab_2">Informação do Requerimento</a>
                                            </li>

                                        </ul>

                                    </div>
                                </div>


                                <?php
                                if ($get_tab === "requerimento_tab_1") require_once("components/info_utente_rnu.php");
                                else if ($get_tab === "requerimento_tab_2") require_once("components/info_requerimento.php");
                                ?>

                                <!-- Fecha Conteudo AQUI! -->
                            </div>
                        </div>
                        <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/footer.php") ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para fazer Avaliação do Requerimento (Valor Avaliação e Notas) -->
    <div class="modal fade" id="avaliar-requerimento" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header" id="modal-avaliar-requerimento-header">
                    <h2 class="fw-bold">Avaliar Requerimento - <?php echo $info_requerimento["numero_requerimento"] ?></h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times fs-1"></i>
                    </div>
                </div>

                <div class="modal-body mx-5 mx-xl-15 my-7">
                    <form id="modal-avaliar-requerimento-form" class="form" action="#">
                        <div class="d-flex flex-column me-n7 pe-7" id="modal-avaliar-requerimento-form-scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#modal-avaliar-requerimento-header" data-kt-scroll-wrappers="#modal-avaliar-requerimento-form-scroll" data-kt-scroll-offset="350px" style="max-height: 91px;">
                            <div class="row g-6">

                                <div class="col-12">
                                    <div class="fv-row">
                                        <label for="grau_avaliacao" class="required fw-semibold fs-6 mb-2 required">Grau Avaliação (Ex: 26.32)</label>
                                        <input type="text" oninput="validarFloat(this)" name="grau_avaliacao" id="grau_avaliacao" class="form-control form-control-solid mb-3 mb-lg-0" value="" placeholder="Grau Avaliação do Requerimento">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Notas / Observações</label>
                                    <textarea class="form-control form-control-solid" name="notas" rows="5" placeholder="Notas / Observações"></textarea>
                                </div>

                            </div>
                        </div>

                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" data-modal-action="submit">
                                <span class="indicator-label">Avaliar</span>
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
        function validarFloat(input) {
            var value = input.value;
            // Permitir números e, no máximo, um ponto
            var novoValor = value.replace(/[^0-9.]/g, '');

            // Se houver mais de um ponto, mantenha apenas o primeiro e ignore os seguintes
            var primeiroPonto = novoValor.indexOf('.');
            if (primeiroPonto !== -1) {
                novoValor = novoValor.substring(0, primeiroPonto + 1) + novoValor.substring(primeiroPonto + 1).replace(/\./g, '');
            }

            input.value = novoValor;
        }
    </script>

    <script>
        const form = document.querySelector("#modal-avaliar-requerimento-form");
        const submitButton = document.querySelector("#modal-avaliar-requerimento-form [data-modal-action=submit]");

        form.addEventListener("submit", (e) => {
            e.preventDefault();
            submitButton.setAttribute("disabled", true);

            const formData = new FormData(form);

            formData.append("hashed_id_utilizador", "<?php echo $id_user ?>");
            formData.append("hashed_id_requerimento", "<?php echo $hashed_id_requerimento ?>");

            const data = {};
            for (const [key, value] of formData.entries()) {
                data[key] = value;
            }

            fetch("http://localhost:8888/api/requerimentos/avaliar", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": token,
                    },
                    body: JSON.stringify(data),
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == "success") {
                        Swal.fire({
                            icon: "success",
                            title: "Sucesso!",
                            text: data.messages[0],
                            buttonsStyling: false,
                            allowOutsideClick: false,
                            showConfirmButton: true,
                            confirmButtonText: 'Confirmar!',
                            didOpen: () => {
                                const confirmButton = Swal.getConfirmButton();
                                confirmButton.blur();
                            },
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            },
                        }).then(() => {
                            window.location.href = "<?php echo $link_home ?>pages/medico/requerimentos/lista";
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Erro!",
                            text: data.messages[0],
                            confirmButtonText: "Voltar",
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: "btn btn-danger",
                            },
                        });
                    }
                })
                .catch((error) => {
                    Swal.fire({
                        icon: "error",
                        title: "Erro!",
                        text: "Ocorreu um erro ao Registar!",
                        confirmButtonText: "Voltar",
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: "btn btn-danger",
                        },
                    });
                })
                .finally(() => {
                    submitButton.removeAttribute("disabled");
                });
        });
    </script>
</body>