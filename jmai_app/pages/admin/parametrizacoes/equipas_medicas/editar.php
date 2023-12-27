<?php
$id = isset($_GET['id']) ? $_GET['id'] : null;
?>
<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/head.php") ?>
<?php $page_name = "Editar - " ?>

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
                                        <form id="form-editar-equipas-medicas" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row mb-6">
                                                        <div class="col-12 col-lg-6">
                                                            <label class="col-12 col-lg-12 col-form-label required fw-semibold fs-6">Selecione os Médicos</label>
                                                            <select class="form-select form-select-solid form-control-lg" name="medicos" data-control="select2" data-close-on-select="false" data-placeholder="Selecione os Médicos" data-allow-clear="true" multiple="multiple">
                                                                <option></option>
                                                            </select>
                                                        </div>

                                                        <div class="col-12 col-lg-6">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Nome da Equipa</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input type="name" name="nome" class="form-control form-control-lg form-control-solid" placeholder="Nome da Equipa" autocomplete="off" value="">
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-lg-6">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Cor da Equipa</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input type="color" name="cor" class="form-control form-control-lg form-control-solid" placeholder="Cor da Equipa" autocomplete="off" value="">
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
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
        const form = document.getElementById("form-editar-equipas-medicas");
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

            fetch(`${api_base_url}equipas_medicas/ver/<?php echo $id; ?>`, requestOptions)
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    if (data.status === "success") {
                        const {
                            medicos,
                            nome,
                            cor
                        } = data.data;
                        form.querySelector("[name='nome']").value = nome;
                        form.querySelector("[name='cor']").value = cor;

                        const select = form.querySelector("[name='medicos']");

                        let selectedValues = [];
                        medicos.forEach((element) => {
                            selectedValues.push(element.hashed_id);
                        });

                        $(select).val(selectedValues).trigger("change");


                        document.querySelector('.page-heading').innerHTML = `Editar Equipa Médica - ${nome}`;

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

        function handleCarregarMedicos() {
            submitButton.setAttribute("data-kt-indicator", "on");
            submitButton.disabled = true;

            const requestOptions = {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "<?php echo $_SESSION['token'] ?>"
                },
            };

            fetch(`${api_base_url}utilizadores/listar?cargo=1&estado=1`, requestOptions)
                .then((response) => response.json())
                .then((data) => {

                    if (data.status === "success") {
                        data.data.forEach((element) => {
                            var option = document.createElement("option");
                            option.value = element.hashed_id;
                            option.text = element.nome;
                            $("select[name='medicos']").append(option);
                        }); 

                        //reinit select2
                        $("select[name='medicos']").select2({
                            placeholder: "Selecione os Médicos",
                            allowClear: true,
                        });

                        submitButton.removeAttribute("data-kt-indicator");
                        submitButton.disabled = false;
                        handleCarregarInformacao();
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

        window.addEventListener("DOMContentLoaded", handleCarregarMedicos);

        function handleEditar(event) {
            event.preventDefault();
            submitButton.setAttribute("data-kt-indicator", "on");
            submitButton.disabled = true;

            var form = document.getElementById("form-editar-equipas-medicas");
            const formData = new FormData(form);

            const medicos = $("select[name='medicos']").val();
            console.log(medicos);
            let medicos_array = [];
            medicos.forEach((element) => {
                medicos_array.push({
                    hashed_id: element
                });
            });
            formData.append("medicos", JSON.stringify(medicos_array));

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

            fetch(`${api_base_url}equipas_medicas/editar/<?php echo $id; ?>`, requestOptions)
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