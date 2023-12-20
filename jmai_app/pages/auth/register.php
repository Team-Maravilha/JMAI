<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/head.php") ?>

<body id="kt_body" class="app-blank bgi-no-repeat">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <style>
            body {
                position: relative;
            }

            body::before {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                background-image: url('<?php echo $link_home ?>assets/media/uploads/fundos/login.jpg');
                background-position: left;
                background-size: auto;
                opacity: 0.5;
                z-index: -1;
            }

            [data-bs-theme="dark"] body::before {
                background-image: url('<?php echo $link_home ?>assets/media/uploads/fundos/login.jpg');
            }
        </style>
        <div class="d-flex flex-column flex-column-fluid flex-lg-row">
            <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10 ms-20">
                <div class="d-flex flex-center flex-lg-start flex-column">
                    <a href="index.html" class="mb-7">
                        <img alt="Logo" class="mw-75" src="<?php echo $link_home ?>assets/media/uploads/logos/logo.svg" />
                    </a>
                    <h1 class="text-dark-blue fw-bold m-0 ls-2 lh-md"><em>Comprometidos com a Verdadeira Medida da Saúde</em></h1>
                </div>
            </div>

            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
                <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                    <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                        <form class="form w-100" novalidate="novalidate" id="login-form">
                            <div class="text-center mb-11">
                                <h1 class="text-gray-900 fs-2x text-dark-blue fw-bolder mb-3">Registar</h1>
                                <div class="text-gray-500 fw-semibold fs-6">Registe-se para obter as suas Credenciais!</div>
                            </div>

                            <div class="separator separator-content my-14">
                                <span class="w-125px text-gray-500 fw-semibold fs-7">Utente</span>
                            </div>

                            <div class="fv-row mb-8">
                                <input type="text" placeholder="Nome Completo" name="nome" autocomplete="off" class="form-control bg-transparent" />
                            </div>
                            <div class="fv-row mb-8">
                                <input type="text" placeholder="Número Utente" name="numero_utente" autocomplete="off" class="form-control bg-transparent" />
                            </div>
                            <div class="fv-row mb-8">
                                <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
                            </div>
                            <div class="fv-row mb-8" data-kt-password-meter="true">
                                <div class="mb-1">
                                    <div class="position-relative mb-3">
                                        <input class="form-control bg-transparent" type="password" placeholder="Palavra-Passe" name="password" autocomplete="off" />
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


                            <div class="d-grid mb-10">
                                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                    <span class="indicator-label">Registar</span>
                                    <span class="indicator-progress">Por Favor Aguarde...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                            <div class="text-gray-500 text-center fw-semibold fs-6">Já tem credenciais?
                                <a href="login" class="link-primary">Iniciar Sessão</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/foo.php") ?>

    <script>
        const numero_utente = document.querySelector(`[name="numero_utente"]`);
        Inputmask({
            mask: "999999999",
            showMaskOnHover: true,
            showMaskOnFocus: true,
        }).mask(numero_utente);
    </script>
</body>

</html>