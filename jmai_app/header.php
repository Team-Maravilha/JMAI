<div id="kt_app_header" class="app-header justify-content-center">
    <div class="app-container container-xxl d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
        <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-color-white btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-duotone ki-abstract-14 fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
        </div>
        <!--begin::Logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-5 me-lg-0">
            <a>
                <img alt="Logo" src="<?php echo $link_home ?>assets/media/uploads/logos/logo-white.svg" class="d-none d-sm-block mw-175px" />
                <img alt="Logo" src="<?php echo $link_home ?>assets/media/uploads/logos/logo-white.svg" class="d-block d-sm-none mw-75px" />
            </a>
        </div>
        <!--end::Logo-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1 ms-8" id="kt_app_header_wrapper">

            <?php if ($_SESSION["role"] === 0) { ?>
                <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                    <div class="menu menu-rounded menu-active-bg menu-state-primary menu-column menu-lg-row menu-title-gray-700 menu-icon-gray-500 menu-arrow-gray-500 menu-bullet-gray-500 my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">

                        <div class="menu-item here menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                            <span class="menu-link">
                                <a href="<?php echo $link_home ?>pages/admin/">
                                <span class="menu-title">Início</span>
                                <span class="menu-arrow d-lg-none"></span>
                                </a>
                            </span>
                        </div>

                        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item here show menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
                            <span class="menu-link">
                                <span class="menu-title">Parametrizações</span>
                                <span class="menu-arrow d-lg-none"></span>
                            </span>
                            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown p-0 w-100 w-lg-850px">
                                <div class="menu-state-bg menu-extended overflow-hidden overflow-lg-visible" data-kt-menu-dismiss="true">
                                    <div class="row">
                                        <div class="col-lg-12 mb-3 mb-lg-0 py-3 px-3 py-lg-6 px-lg-6">
                                            <div class="row">

                                                <div class="col-lg-6 mb-3">
                                                    <div class="menu-item p-0 m-0">
                                                        <a href="<?php echo $link_home ?>pages/admin/parametrizacoes/medicos/lista" class="menu-link">
                                                            <span class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3">
                                                                <i class="ki-solid ki-user-tick text-primary fs-1"></i>
                                                            </span>
                                                            <span class="d-flex flex-column">
                                                                <span class="fs-6 fw-bold text-gray-800">Médicos</span>
                                                                <span class="fs-7 fw-semibold text-muted">Gerir Acessos Médicos</span>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 mb-3">
                                                    <div class="menu-item p-0 m-0">
                                                        <a href="" class="menu-link">
                                                            <span class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3">
                                                                <i class="ki-solid ki-user-edit text-info fs-1"></i>
                                                            </span>
                                                            <span class="d-flex flex-column">
                                                                <span class="fs-6 fw-bold text-gray-800">Rececionistas</span>
                                                                <span class="fs-7 fw-semibold text-muted">Gerir Acessos Rececionistas</span>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 mb-3">
                                                    <div class="menu-item p-0 m-0">
                                                        <a href="" class="menu-link">
                                                            <span class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3">
                                                                <i class="ki-solid ki-profile-user text-warning fs-1"></i>
                                                            </span>
                                                            <span class="d-flex flex-column">
                                                                <span class="fs-6 fw-bold text-gray-800">Equipas Médicas</span>
                                                                <span class="fs-7 fw-semibold text-muted">Gerir Equipas Médicas</span>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            <?php } ?>
            <?php if ($_SESSION["role"] === 1) { ?>
            <?php } ?>
            <?php if ($_SESSION["role"] === 2) { ?>
            <?php } ?>

            <div class="app-navbar flex-shrink-0">
                <div class="app-navbar-item ms-5" id="kt_header_user_menu_toggle">
                    <div class="cursor-pointer symbol symbol-35px symbol-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <img class="symbol symbol-35px symbol-md-40px" src="<?php echo $default_avatar ?>" alt="user" />
                    </div>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <div class="symbol symbol-50px me-5">
                                    <img alt="Logo" src="<?php echo $default_avatar ?>" />
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5"><?php echo $_SESSION["username"] ?>
                                        <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2"><?php echo $_SESSION["role_name"] ?></span>
                                    </div>
                                    <a href="#" class="fw-semibold text-muted text-hover-primary fs-7"><?php echo $_SESSION["email"] ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="separator my-2"></div>
                        <div class="menu-item px-5">
                            <a href="" class="menu-link px-5">Meu Perfil</a>
                        </div>
                        <div class="separator my-2"></div>
                        <div class="menu-item px-5">
                            <a href="<?php echo $link_home ?>pages/auth/logout" class="menu-link px-5">Terminar Sessão</a>
                        </div>
                    </div>
                </div>
                <div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
                    <div class="btn btn-icon btn-color-white btn-active-color-primary w-30px h-30px w-md-35px h-md-35px" id="kt_app_header_menu_toggle">
                        <i class="ki-duotone ki-text-align-left fs-2 fs-md-1 fw-bold">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                        </i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>