<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/_config.php");

session_start();

$role = $_SESSION["role"];

session_destroy();
setcookie("token", "", time() - 3600, "/");

if ($role === 3) {
    header("Location: " . $link_home . "pages/auth/login");
} else {
    header("Location: " . $link_home . "pages/auth/login-user");
}
