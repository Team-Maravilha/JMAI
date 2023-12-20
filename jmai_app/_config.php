<?php
$link_home = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/';
$current_location = $_SERVER["REQUEST_URI"];
$default_avatar = "/assets/media/avatars/blank.png";

if (session_status() !== PHP_SESSION_ACTIVE) session_start();
$id_user = isset($_SESSION["hashed_id"]) ? $_SESSION["hashed_id"] : null;