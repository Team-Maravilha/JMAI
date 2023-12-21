<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/head.php") ?>

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
                                        <form id="form-requerimento" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                                            <div class="card">
                                                <div class="card-body">

                                                    <div class="text-center mb-15">
                                                        <h3 class="fs-2hx text-gray-900 my-6">Faça já o seu Requerimento!</h3>

                                                        <div class="fs-5 text-muted fw-semibold">
                                                            Realize o seu pedido de forma devida, para que o <br> seu requerimento de avaliação de incapacidade possa ser avaliado. <br>
                                                        </div>
                                                    </div>

                                                    <div class="separator separator-content my-15"><span class="h3">Identificação</span></div>
                                                    <div class="row mb-6">
                                                        <div class="col-12 col-lg-6">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Nome Completo</label>
                                                            <input type="text" name="nome" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Nome Completo" value="">
                                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                                        </div>

                                                        <div class="col-12 col-lg-3">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Número de Utente</label>
                                                            <input type="text" name="numero_utente" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Número de Utente" value="">
                                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                                        </div>

                                                        <div class="col-12 col-lg-3">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Tipo Documento</label>
                                                            <select class="form-select form-select-solid" name="tipo_documento" data-control="select2" data-hide-search="true" data-placeholder="Selecione um Tipo de Documento">
                                                                <option></option>
                                                                <option value="0">Cartão de Cidadão</option>
                                                                <option value="1">Bilhete de Identidade</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-12 col-lg-4">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Número Documento</label>
                                                            <input type="text" name="numero_documento" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Número Documento" value="">
                                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                                        </div>

                                                        <div class="col-12 col-lg-4" id="div_data_emissao_documento">
                                                            <label class="col-lg-12 col-form-label required required fw-semibold fs-6">Data de Emissão do Documento</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input class="form-control form-control-solid" name="data_emissao_documento" placeholder="Selecione uma Data de Emissão" id="data" />
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-lg-4" id="div_local_emissao_documento">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Local de Emissão do Documento</label>
                                                            <input type="text" name="local_emissao_documento" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Local de emissão do documento" value="">
                                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                                        </div>

                                                        <div class="col-12 col-lg-4">
                                                            <label class="col-lg-12 col-form-label required required fw-semibold fs-6">Data de Validade do Documento</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input class="form-control form-control-solid" name="data_validade_documento" placeholder="Selecione uma Data de Validade" id="data_validade_documento" />
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-lg-4">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Número de Contribuinte</label>
                                                            <input type="text" name="numero_contribuinte" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Número de Contribuinte" value="">
                                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                                        </div>

                                                        <div class="separator separator-content border-4 my-15"><span class="h3">Naturalidade</span></div>

                                                        <div class="col-12 col-lg-4">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Data de Nascimento</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input class="form-control form-control-solid" name="data_nascimento" placeholder="Selecione uma Data" id="data_nascimento" />
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-lg-4">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">País</label>
                                                            <select class="form-select form-select-solid" name="pais" data-control="select2" data-hide-search="true" data-placeholder="Selecione um País">
                                                                <option></option>
                                                            </select>
                                                        </div>

                                                        <div class="col-12 col-lg-4">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Distrito</label>
                                                            <select class="form-select form-select-solid" name="distrito_naturalidade" data-control="select2" data-hide-search="true" data-placeholder="Selecione um Distrito">
                                                                <option></option>
                                                            </select>
                                                        </div>

                                                        <div class="col-12 col-lg-4">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Concelho</label>
                                                            <select class="form-select form-select-solid" name="concelho_naturadidade" data-control="select2" data-hide-search="true" data-placeholder="Selecione um Concelho">
                                                                <option></option>
                                                            </select>
                                                        </div>

                                                        <div class="col-12 col-lg-4">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Freguesia</label>
                                                            <select class="form-select form-select-solid" name="freguesia_naturadidade" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma Freguesia">
                                                                <option></option>
                                                            </select>
                                                        </div>

                                                        <div class="separator separator-content my-15"><span class="h3">Residência</span></div>

                                                        <div class="col-12 col-lg-6">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Rua</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input type="text" name="morada" class="form-control form-control-lg form-control-solid" placeholder="Morada" value="">
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-lg-3">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Código Postal</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input type="text" name="codigo_postal" class="form-control form-control-lg form-control-solid" placeholder="Código Postal" value="">
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-lg-3">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Distrito</label>
                                                            <select class="form-select form-select-solid" name="distrito_residencia" data-control="select2" data-hide-search="true" data-placeholder="Selecione um Distrito">
                                                                <option></option>
                                                            </select>
                                                        </div>

                                                        <div class="col-12 col-lg-4">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Concelho</label>
                                                            <select class="form-select form-select-solid" name="concelho_residencia" data-control="select2" data-hide-search="true" data-placeholder="Selecione um Concelho">
                                                                <option></option>
                                                            </select>
                                                        </div>

                                                        <div class="col-12 col-lg-4">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Freguesia</label>
                                                            <select class="form-select form-select-solid" name="freguesia_residencia" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma Freguesia">
                                                                <option></option>
                                                            </select>
                                                        </div>

                                                        <div class="col-12 col-lg-4">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Contacto Telemóvel</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input type="text" name="numero_telemovel" class="form-control form-control-lg form-control-solid" placeholder="Número para Contacto Móvel" value="">
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-lg-4">
                                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Contacto Telefónico</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input type="text" name="numero_telefone" class="form-control form-control-lg form-control-solid" placeholder="Número para Contacto Fixo" value="">
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-lg-4">
                                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Contacto Email</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input type="email" name="email" class="form-control form-control-lg form-control-solid" placeholder="Email para Contacto" value="">
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>

                                                        <div class="separator border-5 my-10"></div>

                                                        <div class="fs-5 text-dark fw-semibold">
                                                            Vem solicitar a V. Ex.ª, que ao abrigo do nº 1 do art. 3º do Decreto - Lei nº 291 / 2009 de 12 de outubro seja admitido a Junta Médica para avaliação do grau de incapacidade, para efeitos de:
                                                        </div>
                                                        <div class="g-5">
                                                            <div class="form-check form-check-custom form-check-solid mt-5">
                                                                <input class="form-check-input" name="tipo_requerimento" type="radio" value="0" id="flexRadioDefault" />
                                                                <label class="form-check-label text-dark" for="flexRadioDefault">
                                                                    Multiuso - (Decreto-Lei nº 202/96 de 23 de outubro com a redação dada pelo Decreto-Lei nº 174/97 de 19 de julho).
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-custom form-check-solid mt-5">
                                                                <input class="form-check-input" name="tipo_requerimento" type="radio" value="1" id="flexRadioDefault1" />
                                                                <label class="form-check-label text-dark" for="flexRadioDefault1">
                                                                    Importação de veículo automóvel e outros (Lei nº 22-A/2007 de 29 de junho de 2007).
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="fs-5 g-5 text-dark fw-semibold">
                                                            Comprometendo-se a ser portador de toda a informação clínica respeitante à(s) doença(s) e/ou deficiência(s) que justifica(m) este pedido. Informa ainda que:
                                                        </div>

                                                        <div>
                                                            <div class="form-check form-check-custom form-check-solid mt-5">
                                                                <input class="form-check-input" name="primeira_submissao" type="radio" value="0" id="flexRadioDefault3" />
                                                                <label class="form-check-label text-dark" for="flexRadioDefault3">
                                                                    Nunca foi submetido a Junta Médica de avaliação do grau de incapacidade.
                                                                </label>
                                                            </div>

                                                            <div class="form-check form-check-custom form-check-solid mt-5">
                                                                <input class="form-check-input" name="primeira_submissao" type="radio" value="1" id="flexRadioDefault4" />
                                                                <label class="form-check-label text-dark" for="flexRadioDefault4">
                                                                    Já foi submetido, pretendendo uma reavaliação.
                                                                </label>
                                                            </div>

                                                            <div class="col-12 col-lg-4" id="div_data_submissao_anterior">
                                                                <label class="col-lg-12 col-form-label required fw-semibold fs-6">Data da Última Submissão</label>
                                                                <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                    <input class="form-control form-control-solid" name="data_submissao_anterior" placeholder="Selecione uma Data" id="data_submissao_anterior" />
                                                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="separator border-5 my-6"></div>


                                                        <!--begin::Input group-->
                                                        <div class="form-group row col-12">
                                                            <!--begin::Label-->
                                                            <label class="col-lg-6 col-form-label text-lg-right">Anexe os documentos que achar necessário para a avaliação do seu requerimento:</label>
                                                            <!--end::Label-->

                                                            <!--begin::Col-->
                                                            <div class="col-lg-10">
                                                                <!--begin::Dropzone-->
                                                                <div class="dropzone dropzone-queue mb-2" id="kt_dropzonejs_example_3">
                                                                    <!--begin::Controls-->
                                                                    <div class="dropzone-panel mb-lg-0 mb-2">
                                                                        <a class="dropzone-select btn btn-sm btn-primary me-2">Anexar Documentos</a>
                                                                        <a class="dropzone-upload btn btn-sm btn-light-primary me-2">Carregar Todos</a>
                                                                        <a class="dropzone-remove-all btn btn-sm btn-light-primary">Remover Todos</a>
                                                                    </div>
                                                                    <!--end::Controls-->

                                                                    <!--begin::Items-->
                                                                    <div class="dropzone-items wm-200px">
                                                                        <div class="dropzone-item" style="display:none">
                                                                            <!--begin::File-->
                                                                            <div class="dropzone-file">
                                                                                <div class="dropzone-filename" title="some_image_file_name.jpg">
                                                                                    <span data-dz-name>some_image_file_name.jpg</span>
                                                                                    <strong>(<span data-dz-size>340kb</span>)</strong>
                                                                                </div>

                                                                                <div class="dropzone-error" data-dz-errormessage></div>
                                                                            </div>
                                                                            <!--end::File-->

                                                                            <!--begin::Progress-->
                                                                            <div class="dropzone-progress">
                                                                                <div class="progress">
                                                                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!--end::Progress-->

                                                                            <!--begin::Toolbar-->
                                                                            <div class="dropzone-toolbar">
                                                                                <span class="dropzone-delete" data-dz-remove><i class="bi bi-x fs-1"></i></span>
                                                                            </div>
                                                                            <!--end::Toolbar-->
                                                                        </div>
                                                                    </div>
                                                                    <!--end::Items-->
                                                                </div>
                                                                <!--end::Dropzone-->

                                                                <!--begin::Hint-->
                                                                <span class="form-text text-muted">O tamanho máximo do ficheiro é de 1MB e o número máximo de ficheiros é de 5.</span>
                                                                <!--end::Hint-->
                                                            </div>
                                                            <!--end::Col-->
                                                        </div>
                                                        <!--end::Input group-->


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
        function verificar_tipo_documento() {
            var tipo_documento = $('[name="tipo_documento"]').val();
            if (tipo_documento == 0) {
                document.getElementById("div_local_emissao_documento").classList.add("d-none");
                document.getElementById("div_data_emissao_documento").classList.add("d-none");
            } else {
                document.getElementById("div_local_emissao_documento").classList.remove("d-none");
                document.getElementById("div_data_emissao_documento").classList.remove("d-none");
            }

        }
        verificar_tipo_documento();

        $('[name="tipo_documento"]').change(function() {
            verificar_tipo_documento();
        });

        function verificar_submissao_anterior() {
            var primeira_submissao = $('[name="primeira_submissao"]:checked').val();
            if (primeira_submissao == 1) {
                document.getElementById("div_data_submissao_anterior").classList.remove("d-none");
            } else {
                document.getElementById("div_data_submissao_anterior").classList.add("d-none");
            }

        }
        verificar_submissao_anterior();

        $('[name="primeira_submissao"]').change(function() {
            verificar_submissao_anterior();
        });

        flatpickr("#data_validade_documento", {
            dateFormat: "Y-m-d",
            locale: "pt",
            allowInput: true,
            minDate: "today",
        });

        flatpickr("#data_nascimento", {
            dateFormat: "Y-m-d",
            locale: "pt",
            allowInput: true,
            maxDate: "today",
        });

        flatpickr("#data_submissao_anterior", {
            dateFormat: "Y-m-d",
            locale: "pt",
            allowInput: true,
            maxDate: "today",
        });

        const numero_utente = document.querySelector(`[name="numero_utente"]`);
        Inputmask({
            mask: "999999999",
            showMaskOnHover: true,
            showMaskOnFocus: true,
        }).mask(numero_utente);

        const numero_documento = document.querySelector(`[name="numero_documento"]`);
        Inputmask({
            mask: "99999999",
            showMaskOnHover: true,
            showMaskOnFocus: true,
        }).mask(numero_documento);

        const numero_contribuinte = document.querySelector(`[name="numero_contribuinte"]`);
        Inputmask({
            mask: "999999999",
            showMaskOnHover: true,
            showMaskOnFocus: true,
        }).mask(numero_contribuinte);

        const numero_telemovel = document.querySelector(`[name="numero_telemovel"]`);
        Inputmask({
            mask: "999999999",
            showMaskOnHover: true,
            showMaskOnFocus: true,
        }).mask(numero_telemovel);

        const numero_telefone = document.querySelector(`[name="numero_telefone"]`);
        Inputmask({
            mask: "999999999",
            showMaskOnHover: true,
            showMaskOnFocus: true,
        }).mask(numero_telefone);

        const codigo_postal = document.querySelector(`[name="codigo_postal"]`);
        Inputmask({
            mask: "9999-999",
            showMaskOnHover: true,
            showMaskOnFocus: true,
        }).mask(codigo_postal);
    </script>

    <script>
        const inputPais = $('[name="pais"]'); // ? Input Paises Naturalidade
        const inputDistrito = $('[name="distrito_naturalidade"]'); // ? Input Distritos Naturalidade
        const inputConcelho = $('[name="concelho_naturadidade"]'); // ? Input Concelhos Naturalidade
        const inputFreguesia = $('[name="freguesia_naturadidade"]'); // ? Input Freguesias Naturalidade

        const carregarPaisesNaturalidade = async () => {
            fetch(`${api_base_url}geo/paises/lista?${new URLSearchParams({})}`, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": "<?php echo $_SESSION['token']; ?>"
                    }
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === 'error') {
                        toastr.error(data.messages[0]);
                    } else if (data.status === 'success') {
                        data.data.forEach((pais) => {
                            let option = document.createElement("option");
                            option.value = pais.id_pais;
                            option.text = pais.nome;
                            $(inputPais).append(option);
                        });
                        //REINICIALIZAR SELECT2
                        $(inputPais).select2();
                    }
                });
        };

        const carregarDistritosNaturalidade = async (id_pais) => {
            fetch(`${api_base_url}geo/paises/${id_pais}/distritos/lista?${new URLSearchParams()}`, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": "<?php echo $_SESSION['token']; ?>"
                    }
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === 'error') {
                        toastr.error(data.messages[0]);
                    } else if (data.status === 'success') {
                        data.data.forEach((distrito) => {
                            let option = document.createElement("option");
                            option.value = distrito.id_distrito;
                            option.text = distrito.nome;
                            $(inputDistrito).append(option);
                        });
                        //REINICIALIZAR SELECT2
                        $(inputDistrito).select2();
                    }
                });
        };

        window.addEventListener("DOMContentLoaded", () => {
            carregarPaisesNaturalidade();
            $(inputPais).change(function() {
                $(inputDistrito).empty();
                $(inputDistrito).append('<option></option>');
                $(inputConcelho).empty();
                $(inputConcelho).append('<option></option>');
                $(inputFreguesia).empty();
                $(inputFreguesia).append('<option></option>');
                carregarDistritosNaturalidade($(this).val());
            });

        });
    </script>

    <script>
        // set the dropzone container id
        const id = "#kt_dropzonejs_example_3";
        const dropzone = document.querySelector(id);

        // set the preview element template
        var previewNode = dropzone.querySelector(".dropzone-item");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        var myDropzone = new Dropzone(id, { // Make the whole body a dropzone
            url: "https://keenthemes.com/scripts/void.php", // Set the url for your upload script location
            parallelUploads: 20,
            maxFiles: 5,
            maxFilesize: 1, // Max filesize in MB
            previewTemplate: previewTemplate,
            previewsContainer: id + " .dropzone-items", // Define the container to display the previews
            clickable: id + " .dropzone-select", // Define the element that should be used as click trigger to select files.
            //LOCALE
            dictFileTooBig: "O ficheiro é demasiado grande ({{filesize}}MiB). Tamanho máximo: {{maxFilesize}}MiB.",
            dictInvalidFileType: "Não pode carregar ficheiros deste tipo.",
            dictResponseError: "O servidor respondeu com o código {{statusCode}}.",

        });

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            const dropzoneItems = dropzone.querySelectorAll('.dropzone-item');
            dropzoneItems.forEach(dropzoneItem => {
                dropzoneItem.style.display = '';
            });
        });

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            const progressBars = dropzone.querySelectorAll('.progress-bar');
            progressBars.forEach(progressBar => {
                progressBar.style.width = progress + "%";
            });
        });

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            const progressBars = dropzone.querySelectorAll('.progress-bar');
            progressBars.forEach(progressBar => {
                progressBar.style.opacity = "1";
            });
        });

        // Hide the total progress bar when nothing"s uploading anymore
        myDropzone.on("complete", function(progress) {
            const progressBars = dropzone.querySelectorAll('.dz-complete');

            setTimeout(function() {
                progressBars.forEach(progressBar => {
                    progressBar.querySelector('.progress-bar').style.opacity = "0";
                    progressBar.querySelector('.progress').style.opacity = "0";
                });
            }, 300);
        });
    </script>

</body>