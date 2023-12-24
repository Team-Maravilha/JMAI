<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Informação do Requerimento</h3>
        </div>
    </div>

    <div class="card-body p-9">
        <div class="row">

            <div class="col-12 col-lg-6">

                <h3>Detalhes</h3>
                <div class="separator border-2 my-4"></div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Número Requerimento</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $info_requerimento["numero_requerimento"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Estado Requerimento</label>
                    <div class="col-lg-7">
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
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Tipo Requerimento</label>
                    <div class="col-lg-7">
                        <?php if ($info_requerimento["tipo_requerimento"] === 0) { ?>
                            <span class="badge badge-primary me-2">Multiuso</span>
                        <?php } else if ($info_requerimento["tipo_requerimento"] === 1) { ?>
                            <span class="badge badge-primary me-2">Importação de Veículo</span>
                        <?php } else { ?>
                            <span class="badge badge-light-dark me-2">Sem Informação Tipo</span>
                        <?php } ?>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Tipo Submissão</label>
                    <div class="col-lg-7">
                        <?php if ($info_requerimento["primeira_submissao"] === 1) { ?>
                            <span class="badge badge-success me-2">Primeira Submissão</span>
                        <?php } else if ($info_requerimento["primeira_submissao"] === 0) { ?>
                            <span class="badge badge-danger me-2">ReAvaliação -<span class="ms-1"><?php echo "Data Última Submissão: " . $info_requerimento["data_submissao_anterior"] ?></span></span>
                        <?php } else { ?>
                            <span class="badge badge-light-dark me-2">Sem Informação</span>
                        <?php } ?>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Data Submissão</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $info_requerimento["data_criacao"] ?></span>
                    </div>
                </div>

                <h3>Identificação Utente</h3>
                <div class="separator border-2 my-4"></div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Nome Utente</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $info_requerimento["informacao_utente"]["nome"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Número Utente</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $info_requerimento["informacao_utente"]["numero_utente"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Tipo Doc. Identificação</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $info_requerimento["texto_tipo_documento"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Número Doc. Identificação</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $info_requerimento["numero_documento"] ?></span>
                    </div>
                </div>

                <!-- Mostra Campos se o Tipo de Documento for Bilhete de Identidade -->
                <?php if ($info_requerimento["tipo_documento"] === 1) { ?>

                    <div class="row mb-7">
                        <label class="col-lg-5 fw-semibold text-muted">Data Emissão Doc. Identificação</label>
                        <div class="col-lg-7">
                            <span class="fw-bold fs-6 text-gray-800"><?php echo $info_requerimento["data_emissao_documento"] ?></span>
                        </div>
                    </div>

                    <div class="row mb-7">
                        <label class="col-lg-5 fw-semibold text-muted">Local Emissão Doc. Identificação</label>
                        <div class="col-lg-7">
                            <span class="fw-bold fs-6 text-gray-800"><?php echo $info_requerimento["local_emissao_documento"] ?></span>
                        </div>
                    </div>

                <?php } ?>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Data Validade Doc. Identificação</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $info_requerimento["data_validade_documento"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Número Contribuinte Utente</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $info_requerimento["numero_contribuinte"] ?></span>
                    </div>
                </div>

                <h3>Contactos Utente</h3>
                <div class="separator border-2 my-4"></div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Email Utente</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $info_requerimento["informacao_utente"]["email_autenticacao"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Email Preferencial Requerimento</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo isset($info_requerimento["email_preferencial"]) ? $info_requerimento["email_preferencial"] : "N/A" ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Telemóvel</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $info_requerimento["numero_telemovel"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Telefone</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo isset($info_requerimento["numero_telefone"]) ? $info_requerimento["numero_telefone"] : "N/A" ?></span>
                    </div>
                </div>


            </div>

            <div class="col-12 col-lg-6">

                <h3>Naturalidade Utente</h3>
                <div class="separator border-2 my-4"></div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Data Nascimento Utente</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $info_requerimento["data_nascimento"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Distrito</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $info_requerimento["nome_distrito_naturalidade"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Concelho</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $info_requerimento["nome_concelho_naturalidade"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Freguesia</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $info_requerimento["nome_freguesia_naturalidade"] ?></span>
                    </div>
                </div>

                <h3>Residência Utente</h3>
                <div class="separator border-2 my-4"></div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Rua</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $info_requerimento["morada"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Código-Postal</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $info_requerimento["codigo_postal"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Distrito</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $info_requerimento["nome_distrito_residencia"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Concelho</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $info_requerimento["nome_concelho_residencia"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Freguesia</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $info_requerimento["nome_freguesia_residencia"] ?></span>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>


<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Documentos do Requerimento</h3>
        </div>
    </div>

    <div class="card-body p-9">
        <div class="row">

            <?php foreach ($info_requerimento["documentos_requerimento"] as $key => $value) {

                $extensao = strtolower(pathinfo($value["nome_documento"], PATHINFO_EXTENSION));

                switch ($extensao) {
                    case 'pdf':
                        $icone = $link_home . 'assets/media/svg/files/pdf.svg';
                        break;
                    case 'docx':
                        $icone = $link_home . 'assets/media/svg/files/doc.svg';
                        break;
                    case 'doc':
                        $icone = $link_home . 'assets/media/svg/files/doc.svg';
                        break;
                    case 'word':
                        $icone = $link_home . 'assets/media/svg/files/doc.svg';
                        break;
                    default:
                        $icone = $link_home . 'assets/media/svg/files/upload.svg';
                }

            ?>

                <div class="col-md-6 col-lg-3 col-xl-2 mb-4">
                    <div class="card h-100 ">

                        <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                            <a href="<?php echo $value["caminho_documento"] ?>" target="_blank" class="text-gray-800 text-hover-primary d-flex flex-column">
                                <div class="symbol symbol-60px mb-3">
                                    <img src="<?php echo $icone ?>" class="" alt="">
                                </div>

                                <div class="fs-5 fw-bold mb-1"><?php echo $value["nome_documento"] ?></div>
                            </a>
                        </div>

                    </div>
                </div>

            <?php } ?>

        </div>
    </div>
</div>