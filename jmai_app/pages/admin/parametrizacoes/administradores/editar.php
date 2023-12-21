<?php
$id = isset($_GET['id']) ? $_GET['id'] : null;
?>
<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/head.php") ?>
<?php $page_name = "Editar - Administrador" ?>

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
                                        <form id="form-editar-administrador" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
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

                                                        <div class="col-12 col-lg-6">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Estado</label>
                                                            <select class="form-select form-select-solid" name="estado" autocomplete="off" data-control="select2" data-hide-search="true" data-placeholder="Selecione um Estado">
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
        const form = document.getElementById("form-editar-administrador");
        const submitButton = form.querySelector("[data-element='submit']");

        function handleCarregarInformacao() {
            submitButton.setAttribute("data-kt-indicator", "on");
            submitButton.disabled = true;

            const requestOptions = {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "<?php echo $_SESSION['token'] ?>"
                },
            };

            fetch(`${api_base_url}utilizadores/informacao/<?php echo $id; ?>`, requestOptions)
                .then((response) => response.json())
                .then((data) => {

                    if (data.status === "success") {
                        const {nome, email, estado} = data.data;
                        form.querySelector("[name='nome']").value = nome;
                        form.querySelector("[name='email']").value = email;
                        $('[name="estado"]').val(estado).trigger('change');
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

        window.addEventListener("DOMContentLoaded", handleCarregarInformacao);

        function handleEditar(event) {
            event.preventDefault();
            submitButton.setAttribute("data-kt-indicator", "on");
            submitButton.disabled = true;

            var form = document.getElementById("form-editar-administrador");
            const formData = new FormData(form);
            formData.append("cargo", 0);

            const data = {};
            for (const [key, value] of formData.entries()) {
                data[key] = value;
            }

            const requestOptions = {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "<?php echo $_SESSION['token'] ?>"
                },
                body: JSON.stringify(data),
            };

            fetch(`${api_base_url}utilizadores/editar/<?php echo $id; ?>`, requestOptions)
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

        form.addEventListener("submit", handleEditar);
    </script>


</body> 