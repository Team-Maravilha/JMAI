<?php
$requerimento_info_estados = $api->fetch("requerimentos/historico_estados", null, $hashed_id_requerimento);
$estados = $requerimento_info_estados["response"]["data"];
?>
<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Informação do Histórico de Estados do Requerimento</h3>
        </div>
    </div>

    <div class="card-body p-9">
        <div class="tab-content">

            <div id="kt_activity_today" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_activity_today_tab">
                <div class="timeline timeline-border-dashed">

                    <?php foreach ($estados as $key => $value) { ?>
                        <div class="timeline-item">
                            <div class="timeline-line"></div>

                            <div class="timeline-icon me-4">
                                <i class="ki-duotone ki-flag fs-2 text-gray-500"><span class="path1"></span><span class="path2"></span></i>
                            </div>

                            <div class="timeline-content mt-2">
                                <div class="overflow-auto pe-3">
                                    <div class="fs-5 fw-semibold mb-2">
                                        O utilizador <span class="badge badge-outline badge-dark badge-lg"><?php echo $value["nome_utilizador"] ?></span>
                                        alterou o requerimento <span class="badge badge-outline badge-dark badge-lg"><?php echo $numero_requerimento ?></span>
                                        do estado <?php echo getBadgeForState($value["estado_anterior"]) ?> para <?php echo getBadgeForState($value["estado_novo"]) ?>
                                        a <span class="badge badge-outline badge-dark badge-lg"><?php echo $value["data_hora_alteracao"] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>

        </div>
    </div>
</div>

<?php
function getBadgeForState($estado)
{
    switch ($estado) {
        case 0:
            return '<span class="badge badge-info">Pendente</span>';
        case 1:
            return '<span class="badge badge-warning">Aguarda Avaliação</span>';
        case 2:
            return '<span class="badge badge-light-primary">Avaliado</span>';
        case 3:
            return '<span class="badge badge-primary">A Agendar</span>';
        case 4:
            return '<span class="badge badge-success">Agendado</span>';
        case 5:
            return '<span class="badge badge-dark">Inválido</span>';
        case 6:
            return '<span class="badge badge-danger">Cancelado</span>';
        default:
            return '<span class="badge">Desconhecido</span>';
    }
}
?>