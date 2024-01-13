<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/head.php") ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/api/api.php") ?>
<?php
$api = new Api();
$user = $api->fetch("utentes/ver", null, $id_user);
$user_info = $user["response"]["data"];
$page_name = "O Meu Espaço"
?>

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

                                <div class="row">

                                    <div class="col-xl-8 mb-10">
                                        <div class="card card-flush h-xl-100">
                                            <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px" style="background-image:url('<?php echo $link_home ?>assets/media/svg/shapes/abstract-2.svg')" data-bs-theme="light">
                                                <!--begin::Title-->
                                                <h3 class="card-title align-items-start flex-column text-green pt-15">
                                                    <span class="fw-bold fs-2x mb-3 text-green">Olá, <span class="text-dark-blue"><?php echo $user_info["nome"] ?></span></span>
                                                    <div class="fs-2 text-green">
                                                        <span class="fs-6">Email: <span class="fw-bold text-dark-blue"><?php echo $user_info["email_autenticacao"] ?></span></span><br>
                                                        <span class="fs-6">Número Utente: <span class="fw-bold text-dark-blue"><?php echo $user_info["numero_utente"] ?></span></span><br>
                                                    </div>
                                                </h3>
                                            </div>
                                            <div class="card-body mt-n20">
                                                <div class="mt-n20 position-relative">
                                                    <div class="row g-3 g-lg-6">

                                                        <div class="col-12 col-sm-4">
                                                            <a href="requerimentos/lista">
                                                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                                                    <div class="symbol symbol-30px me-5 mb-8">
                                                                        <span class="symbol-label">
                                                                            <i class="ki-outline ki-document fs-2hx text-primary"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div class="m-0">
                                                                        <span class="text-gray-700 fw-bolder d-block fs-3 lh-1 mb-1">Meus Requerimentos</span>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>

                                                        <div class="col-12 col-sm-4">
                                                            <a href="notificacoes/lista">
                                                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                                                    <div class="symbol symbol-30px me-5 mb-8">
                                                                        <span class="symbol-label">
                                                                            <i class="ki-outline ki-notification-on fs-2hx text-primary"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div class="m-0">
                                                                        <span class="text-gray-700 fw-bolder d-block fs-3 lh-1 mb-1">Notificações</span>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 mb-10">
                                        <div class="card background-blue h-md-100" data-bs-theme="light">
                                            <div class="card-body d-flex flex-column pt-13 pb-14">
                                                <div class="m-0">
                                                    <h1 class="fw-semibold text-white text-center lh-lg fw-bolder">Novo Requerimento</h1>
                                                </div>
                                                <img class="mw-125px align-self-center" src="<?php echo $link_home ?>assets/media/illustrations/unitedpalms-1/4.png">
                                                <div class="text-center">
                                                    <a href="<?php echo $link_home ?>pages/utente/requerimentos/adicionar" class="btn btn-sm bg-white btn-color-gray-800 me-2">Realizar Agora!</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-sm-6 col-xl-3 mb-10">
                                        <div class="card h-lg-100">
                                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                                <div class="m-0">
                                                    <i class="ki-outline ki-file-down fs-2hx text-primary"></i>
                                                </div>
                                                <div class="d-flex flex-column my-7">
                                                    <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" data-element="total_requerimentos_submetidos">0</span>
                                                    <div class="m-0">
                                                        <span class="fw-semibold fs-6 text-gray-400">Requerimentos Submetidos</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xl-3 mb-10">
                                        <div class="card h-lg-100">
                                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                                <div class="m-0">
                                                    <i class="ki-outline ki-tablet-ok fs-2hx text-primary"></i>
                                                </div>
                                                <div class="d-flex flex-column my-7">
                                                    <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" data-element="total_requerimentos_validados">0</span>
                                                    <div class="m-0">
                                                        <span class="fw-semibold fs-6 text-gray-400">Requerimentos Validados</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xl-3 mb-10">
                                        <div class="card h-lg-100">
                                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                                <div class="m-0">
                                                    <i class="ki-outline ki-delete-folder  fs-2hx text-primary"></i>
                                                </div>
                                                <div class="d-flex flex-column my-7">
                                                    <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" data-element="total_requerimentos_invalidos">0</span>
                                                    <div class="m-0">
                                                        <span class="fw-semibold fs-6 text-gray-400">Requerimentos Recusados</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xl-3 mb-10">
                                        <div class="card h-lg-100">
                                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                                <div class="m-0">
                                                    <i class="ki-outline ki-calendar-tick fs-2hx text-primary"></i>
                                                </div>
                                                <div class="d-flex flex-column my-7">
                                                    <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" data-element="total_requerimentos_agendados">0</span>
                                                    <div class="m-0">
                                                        <span class="fw-semibold fs-6 text-gray-400">Juntas Médicas Agendadas</span>
                                                    </div>
                                                </div>
                                            </div>
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
        function handleCarregarDadosDashboard() {

            const requestOptions = {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "<?php echo $_SESSION['token'] ?>"
                },
            };

            fetch(`${api_base_url}graficos/dashboard_totais_por_utente?id_utente=<?php echo $id_user ?>`, requestOptions)
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "success") {
                        const kt_countup_1 = new countUp.CountUp(document.querySelector("[data-element='total_requerimentos_submetidos']"));
                        kt_countup_1.update(data.data.total_requerimentos);

                        const kt_countup_2 = new countUp.CountUp(document.querySelector("[data-element='total_requerimentos_validados']"));
                        kt_countup_2.update(data.data.total_requerimentos_validados);

                        const kt_countup_3 = new countUp.CountUp(document.querySelector("[data-element='total_requerimentos_invalidos']"));
                        kt_countup_3.update(data.data.total_requerimentos_invalidos);

                        const kt_countup_4 = new countUp.CountUp(document.querySelector("[data-element='total_requerimentos_agendados']"));
                        kt_countup_4.update(data.data.total_requerimentos_agendados);

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

        window.addEventListener("DOMContentLoaded", () => {
            setTimeout(function() {
                handleCarregarDadosDashboard();
            }, 1000)
        });
    </script>
</body>