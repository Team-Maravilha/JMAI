<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/_config.php");

session_start();
session_destroy();
setcookie("token", "", time() - 3600, "/");
header("Location: " . $link_home . "pages/auth/login");
