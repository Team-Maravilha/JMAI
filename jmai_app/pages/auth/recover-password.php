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
                background-size: cover !important;
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

            <?php if (isset($_GET["token"]) && isset($_GET["setPassword"])) { ?>
                <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
                    <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                        <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                            <form class="form w-100" novalidate="novalidate" id="recover-password-form">
                                <div class="text-center mb-11">
                                    <h1 class="text-gray-900 fs-2x text-dark-blue fw-bolder mb-3">Recuperar Palavra-Passe</h1>
                                    <div class="text-gray-500 fw-semibold fs-6">Insira a sua nova Palavra-Passe!</div>
                                </div>
                                <div class="fv-row mb-8">

                                    <div class="fv-row mb-8" data-kt-password-meter="true">
                                        <div class="mb-1">
                                            <div class="position-relative mb-3">
                                                <input class="form-control bg-transparent" required type="password" placeholder="Palavra-Passe" name="palavra_passe" autocomplete="off" />
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

                                </div>
                                <div class="d-grid mb-10">
                                    <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                        <span class="indicator-label">Alterar Palavra-Passe</span>
                                        <span class="indicator-progress">Por Favor Aguarde...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } elseif (isset($_GET['token'])) { ?>
                <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
                    <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                        <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                            <form class="form w-100" novalidate="novalidate" id="recover-password-form">
                                <div class="text-center mb-11">
                                    <h1 class="text-gray-900 fs-2x text-dark-blue fw-bolder mb-3">Recuperar Palavra-Passe</h1>
                                    <div class="text-gray-500 fw-semibold fs-6">Aceda ao seu Email e insira o código de segurança!</div>
                                </div>
                                <div class="fv-row mb-8">
                                    <div class="fw-bold text-center text-xl-start text-dark fs-6 mb-1 ms-1">Digite o seu código de segurança de 6 dígitos</div>

                                    <div class="d-flex flex-wrap justify-content-center justify-content-xl-between">
                                        <input type="text" name="code-1" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2" value="" inputmode="numeric">
                                        <input type="text" name="code-2" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2" value="" inputmode="numeric">
                                        <input type="text" name="code-3" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2" value="" inputmode="numeric">
                                        <input type="text" name="code-4" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2" value="" inputmode="numeric">
                                        <input type="text" name="code-5" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2" value="" inputmode="numeric">
                                        <input type="text" name="code-6" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2" value="" inputmode="numeric">
                                    </div>

                                </div>
                                <div class="d-grid mb-10">
                                    <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                        <span class="indicator-label">Verificar Código</span>
                                        <span class="indicator-progress">Por Favor Aguarde...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
                    <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                        <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                            <form class="form w-100" novalidate="novalidate" id="recuperar-palavra-passe-form">
                                <div class="text-center mb-11">
                                    <h1 class="text-gray-900 fs-2x text-dark-blue fw-bolder mb-3">Recuperar Palavra-Passe</h1>
                                    <div class="text-gray-500 fw-semibold fs-6">Insira o seu Email!</div>
                                </div>
                                <div class="fv-row mb-8">
                                    <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
                                </div>
                                <div class="d-grid mb-10">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">Recuperar Palavra-Passe</span>
                                        <span class="indicator-progress">Por Favor Aguarde...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/foo.php") ?>
    <?php if (isset($_GET["token"]) && isset($_GET["setPassword"])) { ?>
        <script>
            var form = document.getElementById("recover-password-form");
            var submitButton = form.querySelector("button[type=submit]");
            const validarToken2 = () => {

                const token = "<?php echo $_GET['token'] ?>";

                fetch(`${api_base_url}autenticacao/utente/recuperar-palavra-passe/verificar/${token}`, {
                        method: "GET",
                        headers: {
                            "Content-Type": "application/json",
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "success") {
                            toastr.error("O seu Código de Verificação não se encontra válido!");
                            setTimeout(() => {
                                window.location.href = `recover-password?token=${token}`;
                            }, 2000);
                        } else if (data.status === "warning") {
                            submitButton.removeAttribute("disabled");
                            submitButton.removeAttribute("data-kt-indicator");
                        } else {
                            toastr.error(data.messages[0], "Erro!");
                            setTimeout(() => {
                                window.location.href = `recover-password`;
                            }, 2000);
                        }
                    }).catch(error => {
                        toastr.error("Ocorreu um erro ao processar o pedido!");
                    }).finally(() => {});
            }

            const submitFormAlterarPalavraPasse = () => {

                const formData = new FormData(form);
                if (!formData.get("palavra_passe")) return toastr.error("Por favor preencha o campo Palavra-Passe!");

                const data = {};
                for (const [key, value] of formData.entries()) {
                    data[key] = value;
                }

                submitButton.setAttribute("disabled", true);
                submitButton.setAttribute("data-kt-indicator", "on");

                const token = "<?php echo $_GET['token'] ?>";

                Swal.fire({
                    icon: "warning",
                    title: "Tem a certeza?",
                    text: "Ao alterar a sua Palavra-Passe irá ser redirecionado para a página de Login!",
                    buttonsStyling: false,
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Sim, Alterar!",
                    customClass: {
                        confirmButton: "btn fw-bold btn-primary",
                        cancelButton: "btn fw-bold btn-active-light-primary",
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`${api_base_url}autenticacao/utente/recuperar-palavra-passe/alterar`, {
                                method: "PUT",
                                body: JSON.stringify({
                                    token: token,
                                    palavra_passe: data.palavra_passe
                                }),
                                headers: {
                                    "Content-Type": "application/json",
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === "success") {
                                    toastr.success(data.messages[0], "Sucesso!");
                                    setTimeout(() => {
                                        window.location.href = `login`;
                                    }, 2000);
                                } else {
                                    toastr.error(data.messages[0], "Erro!");
                                }
                            }).catch(error => {
                                toastr.error("Ocorreu um erro ao processar o pedido!");
                            }).finally(() => {
                                submitButton.removeAttribute("disabled");
                                submitButton.removeAttribute("data-kt-indicator");
                            });
                    } else {
                        submitButton.removeAttribute("disabled");
                        submitButton.removeAttribute("data-kt-indicator");
                    }
                });
            }

            document.addEventListener("DOMContentLoaded", function() {
                validarToken2();
                form.addEventListener("submit", function(event) {
                    event.preventDefault();
                    submitFormAlterarPalavraPasse()
                });
            });
        </script>
    <?php } elseif (isset($_GET['token'])) { ?>
        <script>
            var form = document.getElementById("recover-password-form");
            var submitButton = form.querySelector("button[type=submit]");
            const handleType = () => {
                const input1 = form.querySelector("[name=code-1]");
                const input2 = form.querySelector("[name=code-2]");
                const input3 = form.querySelector("[name=code-3]");
                const input4 = form.querySelector("[name=code-4]");
                const input5 = form.querySelector("[name=code-5]");
                const input6 = form.querySelector("[name=code-6]");

                input1.focus();

                input1.addEventListener("keyup", (ev) => {
                    if (ev.target.value.length === 1) input2.focus();
                    else if (ev.keyCode === 8) input1.focus();
                });

                input2.addEventListener("keyup", (ev) => {
                    if (ev.target.value.length === 1) input3.focus();
                    else if (ev.keyCode === 8) input1.focus();
                });

                input3.addEventListener("keyup", (ev) => {
                    if (ev.target.value.length === 1) input4.focus();
                    else if (ev.keyCode === 8) input2.focus();
                });

                input4.addEventListener("keyup", (ev) => {
                    if (ev.target.value.length === 1) input5.focus();
                    else if (ev.keyCode === 8) input3.focus();
                });

                input5.addEventListener("keyup", (ev) => {
                    if (ev.target.value.length === 1) input6.focus();
                    else if (ev.keyCode === 8) input4.focus();
                });

                input6.addEventListener("keyup", (ev) => {
                    if (ev.target.value.length === 1) input6.blur();
                    else if (ev.keyCode === 8) input5.focus();
                });
            }
            const validarToken = () => {

                const token = "<?php echo $_GET['token'] ?>";

                fetch(`${api_base_url}autenticacao/utente/recuperar-palavra-passe/verificar/${token}`, {
                        method: "GET",
                        headers: {
                            "Content-Type": "application/json",
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "success") {
                            //toastr.success(data.messages[0], "Sucesso!");
                            submitButton.removeAttribute("disabled");
                            submitButton.removeAttribute("data-kt-indicator");
                        } else if (data.status === "warning") {
                            submitButton.removeAttribute("disabled");
                            submitButton.removeAttribute("data-kt-indicator");
                        } else {
                            toastr.error(data.messages[0], "Erro!");
                            setTimeout(() => {
                                window.location.href = `recover-password`;
                            }, 2000);
                        }
                    }).catch(error => {
                        toastr.error("Ocorreu um erro ao processar o pedido!");
                    }).finally(() => {});
            }
            const submitFormValidarCodigoToken = () => {

                const formData = new FormData(form);
                if (!formData.get("code-1")) return toastr.error("Por favor preencha o campo Código!");
                if (!formData.get("code-2")) return toastr.error("Por favor preencha o campo Código!");
                if (!formData.get("code-3")) return toastr.error("Por favor preencha o campo Código!");
                if (!formData.get("code-4")) return toastr.error("Por favor preencha o campo Código!");
                if (!formData.get("code-5")) return toastr.error("Por favor preencha o campo Código!");
                if (!formData.get("code-6")) return toastr.error("Por favor preencha o campo Código!");

                const codigo_verificacao = `${formData.get("code-1")}${formData.get("code-2")}${formData.get("code-3")}${formData.get("code-4")}${formData.get("code-5")}${formData.get("code-6")}`;

                submitButton.setAttribute("disabled", true);
                submitButton.setAttribute("data-kt-indicator", "on");

                const token = "<?php echo $_GET['token'] ?>";

                fetch(`${api_base_url}autenticacao/utente/recuperar-palavra-passe/validar`, {
                        method: "PUT",
                        body: JSON.stringify({
                            token: token,
                            codigo_verificacao: codigo_verificacao
                        }),
                        headers: {
                            "Content-Type": "application/json",
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "success") {
                            toastr.success(data.messages[0], "Sucesso!");
                            setTimeout(() => {
                                window.location.href = `recover-password?token=${token}&setPassword`;
                            }, 2000);
                        } else {
                            toastr.error(data.messages[0], "Erro!");
                        }
                    }).catch(error => {
                        toastr.error("Ocorreu um erro ao processar o pedido!");
                    }).finally(() => {
                        submitButton.removeAttribute("disabled");
                        submitButton.removeAttribute("data-kt-indicator");
                    });
            }

            document.addEventListener("DOMContentLoaded", function() {
                handleType();
                validarToken();
                form.addEventListener("submit", function(event) {
                    event.preventDefault();
                    submitFormValidarCodigoToken()
                });
            });
        </script>
    <?php } else { ?>
        <script>
            var form = document.getElementById("recuperar-palavra-passe-form");
            var submitButton = form.querySelector("button[type=submit]");

            const submitFormRecuperarPalavraPasse = () => {

                const formData = new FormData(form);
                if (!formData.get("email")) return toastr.error("Por favor preencha o campo Email!");

                const data = {};
                for (const [key, value] of formData.entries()) {
                    data[key] = value;
                }

                submitButton.setAttribute("disabled", true);
                submitButton.setAttribute("data-kt-indicator", "on");

                fetch(`${api_base_url}autenticacao/utente/recuperar-palavra-passe`, {
                        method: "POST",
                        body: JSON.stringify(data),
                        headers: {
                            "Content-Type": "application/json",
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "success") {
                            toastr.success(data.messages[0], "Sucesso!");
                            setTimeout(() => {
                                window.location.href = `recover-password?token=${data.data.token}`;
                            }, 2000);
                        } else {
                            toastr.error(data.messages[0], "Erro!");
                        }
                    }).catch(error => {
                        toastr.error("Ocorreu um erro ao processar o pedido!");
                    }).finally(() => {
                        submitButton.removeAttribute("disabled");
                        submitButton.removeAttribute("data-kt-indicator");
                    });
            }

            document.addEventListener("DOMContentLoaded", function() {
                form.addEventListener("submit", function(event) {
                    event.preventDefault();
                    submitFormRecuperarPalavraPasse()
                });
            });
        </script>
    <?php } ?>
</body>

</html>