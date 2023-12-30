<?php
$link_home = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/';
$current_location = $_SERVER["REQUEST_URI"];
$default_avatar = "/assets/media/avatars/blank.png";

if (session_status() !== PHP_SESSION_ACTIVE) session_start();
$id_user = isset($_SESSION["hashed_id"]) ? $_SESSION["hashed_id"] : null;


$breadcrumbs = [
    [
        "name" => "Utentes",
        "path" => "utentes",
        "link" => "/pages/admin/utentes/lista",
        "role" => 0,
        "clickable" => true
    ],
    [
        "name" => "Parametrizações",
        "path" => "parametrizacoes",
        "link" => "/pages/admin/parametrizacoes/",
        "role" => 0,
        "clickable" => false
    ],
    [
        "name" => "Administradores",
        "path" => "administradores",
        "link" => "/pages/admin/parametrizacoes/administradores/lista",
        "role" => 0,
        "clickable" => true
    ],
    [
        "name" => "Equipas Médicas",
        "path" => "equipas_medicas",
        "link" => "/pages/admin/parametrizacoes/equipas_medicas/lista",
        "role" => 0,
        "clickable" => true
    ],
    [
        "name" => "Rececionistas",
        "path" => "rececionistas",
        "link" => "/pages/admin/parametrizacoes/rececionistas/lista",
        "role" => 0,
        "clickable" => true
    ],
    [
        "name" => "Médicos",
        "path" => "medicos",
        "link" => "/pages/admin/parametrizacoes/medicos/lista",
        "role" => 0,
        "clickable" => true
    ],
    [
        "name" => "Requerimentos",
        "path" => "requerimentos",
        "link" => "/pages/admin/requerimentos/lista",
        "role" => 0,
        "clickable" => true
    ],
    [
        "name" => "Requerimentos",
        "path" => "requerimentos",
        "link" => "/pages/medico/requerimentos/lista",
        "role" => 1,
        "clickable" => true
    ],
    [
        "name" => "Requerimentos",
        "path" => "requerimentos",
        "link" => "/pages/rececionista/requerimentos/lista",
        "role" => 2,
        "clickable" => true
    ],
    [
        "name" => "Requerimentos",
        "path" => "requerimentos",
        "link" => "/pages/utente/requerimentos/lista",
        "role" => 3,
        "clickable" => true
    ],
    [
        "name" => "Notificações",
        "path" => "notificacoes",
        "link" => "/pages/utente/notificacoes/lista",
        "role" => 3,
        "clickable" => true
    ],
    [
        "name" => "Agendamento de Requerimentos",
        "path" => "agendar_requerimentos",
        "link" => "/pages/rececionista/agendar_requerimentos/lista",
        "role" => 2,
        "clickable" => true
    ],
];
