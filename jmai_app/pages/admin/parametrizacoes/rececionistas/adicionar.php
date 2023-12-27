<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/head.php") ?>
<?php $page_name = "Adicionar Novo Utilizador - Rececionista" ?>

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

                                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start  container-xxl ">
                                    <div class="content flex-row-fluid" id="kt_content">
                                        <form id="form-adicionar-rececionista" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row mb-6">
                                                        <div class="col-12 col-lg-6">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Nome Completo</label>
                                                            <input type="text" name="nome" autocomplete="off" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Nome Completo" value="">
                                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                                        </div>

                                                        <div class="col-12 col-lg-6">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Contacto Email</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input type="email" name="email" class="form-control form-control-lg form-control-solid" placeholder="Email para Contacto" autocomplete="off" value="">
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>



                                                        <div class="fv-row mb-8 col-21 col-lg-6" data-kt-password-meter="true">
                                                            <div class="mb-1">
                                                                <label class="col-lg-12 col-form-label required fw-semibold fs-6">Palavra-Passe</label>
                                                                <div class="position-relative mb-3">
                                                                    <input class="form-control form-control-lg form-control-solid" required type="password" placeholder="Palavra-Passe" name="palavra_passe" autocomplete="off" />
                                                                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                                                        <i class="ki-duotone ki-eye-slash fs-2"></i>
                                                                        <i class="ki-duotone ki-eye fs-2 d-none"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                                                </div>
                                                            </div>
                                                            <div class="text-muted">Utilize 8 ou mais caracteres com uma mistura de letras, números e símbolos</div>
                                                        </div>

                                                        <div class="col-12 col-lg-6">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Estado</label>
                                                            <select class="form-select form-control-lg form-select-solid" name="estado" autocomplete="off" data-control="select2" data-hide-search="true" data-placeholder="Selecione um Estado">
                                                                <option></option>
                                                                <option value="1">Ativo</option>
                                                                <option value="0">Inativo</option>
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card-footer d-flex justify-content-end py-6 px-9 g-5">
                                                    <button type="reset" class="btn btn-light btn-active-light-primary me-2">Cancelar</button>
                                                    <button type="submit" class="btn btn-primary" data-element="submit">
                                                        <span class="indicator-label">
                                                            Submeter
                                                        </span>
                                                        <span class="indicator-progress">
                                                            Por favor Aguarde... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
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
        const form = document.getElementById("form-adicionar-rececionista");
        const submitButton = form.querySelector("[data-element='submit']");

        function handleAdicionar(event) {
            event.preventDefault();
            submitButton.setAttribute("data-kt-indicator", "on");
            submitButton.disabled = true;

            var form = document.getElementById("form-adicionar-rececionista");
            const formData = new FormData(form);

            const data = {};
            for (const [key, value] of formData.entries()) {
                data[key] = value;
            }

            const requestOptions = {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "<?php echo $_SESSION['token'] ?>",
                },
                body: JSON.stringify(data),
            };

            fetch(`${api_base_url}utilizadores/registar/rececionista`, requestOptions)
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "success") {
                        toastr.success(data.messages[0], "Sucesso!");
                        setTimeout(() => {
                            window.location.href = "lista";
                        }, 1000);
                    } else {
                        toastr.error(data.messages[0], "Erro!");
                    }
                })
                .catch((error) => {
                    toastr.error(error, "Erro!");
                })
                .finally(() => {
                    submitButton.removeAttribute("data-kt-indicator");
                    submitButton.disabled = false;
                });
        }

        form.addEventListener("submit", handleAdicionar);
    </script>


</body>