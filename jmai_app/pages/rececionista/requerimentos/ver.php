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
$numero_utente = $info_requerimento["informacao_utente"]["numero_utente"];

$patient_info = $api_rnu->fetch("patients/num_utente", null, $numero_utente);
$patient_info_data = $patient_info["response"][0];

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
                                                            <a class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"><?php echo $patient_info_data["nome"] ?></a><a class="text-gray-900 text-hover-primary fs-3 ms-2">Nº Utente:<?php echo $patient_info_data["num_utente"] ?></a>
                                                        </div>

                                                        <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                                <i class="ki-outline ki-sms fs-4 me-1"></i><?php echo isset($patient_info_data["email"]) ? $patient_info_data["email"] : "N/A" ?></a>
                                                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                                <i class="ki-outline ki-phone fs-4 me-1"></i><?php echo $patient_info_data["num_telemovel"] ?></a>
                                                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                                                <i class="ki-outline ki-information-2 fs-4 me-1"></i>
                                                                <?php echo (new DateTime($patient_info_data["data_criacao"]))->format("d/m/Y - H:i") . "h"; ?>
                                                        </div>
                                                        <span class="badge badge-success me-2">Utente</span>
                                                        <?php if ($patient_info_data["genero"] === 1) { ?>
                                                            <span class="badge badge-warning me-2">Masculino</span>
                                                        <?php } else if ($patient_info_data["genero"] === 2) { ?>
                                                            <span class="badge badge-warning me-2">Feminino</span>
                                                        <?php } else { ?>
                                                            <span class="badge badge-warning me-2">Outro</span>
                                                        <?php } ?>

                                                        <?php if ($patient_info_data["taxa_moderadora"] === 1) { ?>
                                                            <span class="badge badge-success me-2">Com Isenção Taxa Moderadora</span>
                                                        <?php } else if ($patient_info_data["taxa_moderadora"] === 0) { ?>
                                                            <span class="badge badge-danger me-2">Sem Isenção Taxa Moderadora</span>
                                                        <?php } else { ?>
                                                            <span class="badge badge-light-dark me-2">Sem Informação Taxa Moderadora</span>
                                                        <?php } ?>

                                                        <?php if ($patient_info_data["seguro_saude"] === 1) { ?>
                                                            <span class="badge badge-success me-2">Com Seguro de Saúde</span>
                                                        <?php } else if ($patient_info_data["seguro_saude"] === 0) { ?>
                                                            <span class="badge badge-danger me-2">Sem Seguro de Saúde</span>
                                                        <?php } else { ?>
                                                            <span class="badge badge-light-dark me-2">Sem Informação Seguro de Saúde</span>
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
	<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/foo.php") ?>
</body>