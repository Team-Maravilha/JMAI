<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Informação do Pedido</h3>
        </div>
    </div>

    <div class="card-body p-9">
        <div class="row">
            <div class="col-6">

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Nome Completo</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $patient_info_data["nome"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Género</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800">
                            <?php if ($patient_info_data["genero"] === 1) { ?>
                                Masculino
                            <?php } else if ($patient_info_data["genero"] === 2) { ?>
                                Feminino
                            <?php } else { ?>
                                Outro
                            <?php } ?>
                        </span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Data de Nascimento</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo (new DateTime($patient_info_data["data_nascimento"]))->format("d/m/Y"); ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Email</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo isset($patient_info_data["email"]) ? $patient_info_data["email"] : "N/A" ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Número Telemóvel</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo isset($patient_info_data["num_telemovel"]) ? $patient_info_data["num_telemovel"] : "N/A" ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Número Telefone</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo isset($patient_info_data["num_telefone"]) ? $patient_info_data["num_telefone"] : "N/A" ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Número Documento</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $patient_info_data["num_cc"] . " " . $patient_info_data["cod_validacao_cc"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Data Validade do Documento</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo (new DateTime($patient_info_data["data_validade_cc"]))->format("d/m/Y"); ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Número Identificação Fiscal</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $patient_info_data["num_ident_fiscal"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Número Segurança Social</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $patient_info_data["num_ident_seg_social"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Número Utente</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $patient_info_data["num_utente"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Pai</label>
                    <div class="col-lg-7">
                        <a class="text-hover-primary"><span class="text-hover-primary fw-bold fs-6 text-gray-800"><i class="ki-outline ki-profile-user text-black fw-bold fs-4 me-1"></i><?php echo isset($patient_info_data["pai"]["nome"]) ? $patient_info_data["pai"]["nome"] : "N/A" ?></span></a>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Mãe</label>
                    <div class="col-lg-7">
                        <a class="text-hover-primary"><span class="text-hover-primary fw-bold fs-6 text-gray-800"><i class="ki-outline ki-profile-user text-black fw-bold fs-4 me-1"></i><?php echo isset($patient_info_data["mae"]["nome"]) ? $patient_info_data["mae"]["nome"] : "N/A" ?></span></a>
                    </div>
                </div>

            </div>

            <div class="col-6">

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Estado Civil</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800">
                            <?php if ($patient_info_data["estado_civil"] === 1) { ?>
                                Solteiro(a)
                            <?php } else if ($patient_info_data["estado_civil"] === 2) { ?>
                                Casado(a)
                            <?php } else if ($patient_info_data["estado_civil"] === 3) { ?>
                                União de Facto
                            <?php } else if ($patient_info_data["estado_civil"] === 4) { ?>
                                Divorciado(a)
                            <?php } else if ($patient_info_data["estado_civil"] === 5) { ?>
                                Viúvo(a)
                            <?php } ?>
                        </span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Situação Profissional</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800">
                            <?php if ($patient_info_data["situacao_profissional"] === 1) { ?>
                                Estudante
                            <?php } else if ($patient_info_data["situacao_profissional"] === 2) { ?>
                                Desempregado(a)
                            <?php } else if ($patient_info_data["situacao_profissional"] === 3) { ?>
                                Empregado(a)
                            <?php } else if ($patient_info_data["situacao_profissional"] === 4) { ?>
                                Reformado(a)
                            <?php } else if ($patient_info_data["situacao_profissional"] === 5) { ?>
                                Outra
                            <?php } ?>
                        </span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Profissão</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo isset($patient_info_data["profissao"]) ? $patient_info_data["profissao"] : "N/A" ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Hablitações Escolares</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo isset($patient_info_data["hab_escolares"]) ? $patient_info_data["hab_escolares"] : "N/A" ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">País</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $patient_info_data["morada"]["pais"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Distrito</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $patient_info_data["morada"]["distrito"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Concelho</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $patient_info_data["morada"]["concelho"] ?></span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Freguesia</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $patient_info_data["morada"]["freguesia"] ?></span>
                    </div>
                </div>


                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Morada</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800">
                            <?php echo $patient_info_data["morada"]["morada"] . ' ' . $patient_info_data["morada"]["numero_porta"] . ' ' . $patient_info_data["morada"]["andar"]
                            ?>
                        </span>
                    </div>
                </div>

                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Código-Postal</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800"><?php echo $patient_info_data["morada"]["cod_postal"] ?></span>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>