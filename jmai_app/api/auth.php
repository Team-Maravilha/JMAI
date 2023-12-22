<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/_config.php");

if (isset($_SERVER["REQUEST_METHOD"])) {
    switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            echo "O método GET não é suportado neste ficheiro por vias de segurança.";
            break;
        case "POST":
            if (!isset($_POST["action"])) {
                echo "Ação não existe";
                break;
            }

            switch ($_POST["action"]) {
                case "login":
                    $email = $_POST["email"];
                    $palavra_passe = $_POST["palavra_passe"];

                    require_once($_SERVER["DOCUMENT_ROOT"] . "/api/api.php");

                    $api = new Api();
                    $verify_user_login = $api->post("autenticacao/login-utilizador", ["email" => $email, "palavra_passe" => $palavra_passe]);

                    if ($verify_user_login["status"]) {
                        if ($verify_user_login["response"]["status"] === "success") {
                            if (session_status() !== PHP_SESSION_ACTIVE) session_start();
                            $_SESSION["hashed_id"] = $verify_user_login["response"]["data"]["hashed_id"];
                            $_SESSION["username"] = $verify_user_login["response"]["data"]["nome"];
                            $_SESSION["email"] = $verify_user_login["response"]["data"]["email"];
                            $_SESSION["role"] = $verify_user_login["response"]["data"]["cargo"];
                            $_SESSION["role_name"] = $verify_user_login["response"]["data"]["texto_cargo"];
                            $_SESSION["token"] = $verify_user_login["response"]["data"]["token"];
                            // Enviar o Token para as Cookies
                            setcookie("token", $verify_user_login["response"]["data"]["token"], time() + (86400 * 8), "/");

                            if ($_SESSION["role"] === 0) {
                                $redirect = "/pages/admin/index";
                            } else if ($_SESSION["role"] === 1) {
                                $redirect = "/pages/medico/index";
                            } else if ($_SESSION["role"] === 2) {
                                $redirect = "/pages/rececionista/index";
                            }
                            $verify_user_login["response"]["redirect"] = $redirect;
                        }
                    }

                    echo json_encode($verify_user_login["response"]);
                    break;

                case "loginUtente":
                    $email = $_POST["email"];
                    $palavra_passe = $_POST["palavra_passe"];

                    require_once($_SERVER["DOCUMENT_ROOT"] . "/api/api.php");

                    $api = new Api();
                    $verify_user_login = $api->post("autenticacao/login-utente", ["email" => $email, "palavra_passe" => $palavra_passe]);

                    if ($verify_user_login["status"]) {
                        if ($verify_user_login["response"]["status"] === "success") {
                            if (session_status() !== PHP_SESSION_ACTIVE) session_start();
                            $_SESSION["hashed_id"] = $verify_user_login["response"]["data"]["hashed_id"];
                            $_SESSION["username"] = $verify_user_login["response"]["data"]["nome"];
                            $_SESSION["email"] = $verify_user_login["response"]["data"]["email_autenticacao"];
                            $_SESSION["role"] = $verify_user_login["response"]["data"]["cargo"];
                            $_SESSION["role_name"] = $verify_user_login["response"]["data"]["texto_cargo"];
                            $_SESSION["token"] = $verify_user_login["response"]["data"]["token"];
                            // Enviar o Token para as Cookies
                            setcookie("token", $verify_user_login["response"]["data"]["token"], time() + (86400 * 8), "/");


                            if ($_SESSION["role"] === 3) {
                                $redirect = "/pages/utente/index";
                            } else {
                                $redirect = "/pages/auth/login";
                            }
                            $verify_user_login["response"]["redirect"] = $redirect;
                        }
                    }

                    echo json_encode($verify_user_login["response"]);
                    break;
            }

            break;

        default:
            echo json_encode("Método não suportado!");
            break;
    }
}
