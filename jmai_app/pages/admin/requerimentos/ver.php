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
$numero_requerimento = $info_requerimento["numero_requerimento"];
$numero_utente = $info_requerimento["informacao_utente"]["numero_utente"];

$patient_info = $api_rnu->fetch("patients/num_utente", null, $numero_utente);
if($patient_info["status"] == false){
    $patient_info_data = null;
} else {
    $patient_info_data = $patient_info["response"][0];
}

$get_tab = isset($_GET["tab"]) ? $_GET["tab"] : "requerimento_tab_2";
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

                                            <li class="nav-item mt-2">
                                                <a class="nav-link text-active-primary ms-0 me-10 py-5 <?php if ($get_tab === "requerimento_tab_3") echo "active"; ?>" href="?id=<?php echo $hashed_id; ?>&tab=requerimento_tab_3">Histórico de Acessos</a>
                                            </li>

                                            <li class="nav-item mt-2">
                                                <a class="nav-link text-active-primary ms-0 me-10 py-5 <?php if ($get_tab === "requerimento_tab_4") echo "active"; ?>" href="?id=<?php echo $hashed_id; ?>&tab=requerimento_tab_4">Histórico de Estados</a>
                                            </li>

                                        </ul>

                                    </div>
                                </div>


                                <?php
                                if ($get_tab === "requerimento_tab_1") require_once("components/info_utente_rnu.php");
                                else if ($get_tab === "requerimento_tab_2") require_once("components/info_requerimento.php");
                                else if ($get_tab === "requerimento_tab_3") require_once("components/historico_acessos.php");
                                else if ($get_tab === "requerimento_tab_4") require_once("components/historico_estados.php");
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

    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/foo.php") ?>

</body>