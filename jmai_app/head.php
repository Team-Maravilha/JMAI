<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/_config.php") ?>
<?php


if (is_null($id_user)) { // Se o utilizador não estiver logado, redireciona para a página de autenticação.
    $request_uri = $_SERVER['REQUEST_URI'];
    $path = explode('/', $request_uri);
    $folder_name = isset($path[2]) ? $path[2] : null;
    if ($folder_name != 'auth') { // Se o utilizador não estiver logado e não estiver na página de autenticação, redireciona para a página de autenticação.
        header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/pages/auth/login');
        exit;
    }
} else {
    $request_uri = $_SERVER['REQUEST_URI'];
    $path = explode('/', $request_uri);
    $folder_name = isset($path[2]) ? $path[2] : null;
    if ($folder_name == 'auth' || is_null($folder_name)) { // Se o utilizador estiver logado e estiver na página de autenticação, redireciona para a página de dashboard.
        if ($_SESSION['role'] == 0) {
            header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/pages/admin/');
            exit;
        } elseif ($_SESSION['role'] == 1) {
            header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/pages/medico/');
            exit;
        } elseif ($_SESSION['role'] == 2) {
            header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/pages/rececionista/');
            exit;
        } elseif ($_SESSION['role'] == 3) {
            header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/pages/utente/');
            exit;
        }
    }
}

?>

<head>
    <title>JMAI</title>
    <meta charset="utf-8" />
    <meta name="description" content="Juntas Médicas para Avaliação de Incapacidade" />
    <meta name="keywords" content="HTML CSS JS PHP ExpressJS PostgreSQL Bootstrap" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="<?php echo $link_home ?>assets/media/uploads/logos/favicon.svg" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="<?php echo $link_home ?>assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $link_home ?>assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $link_home ?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $link_home ?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $link_home ?>assets/css/style.css" rel="stylesheet" type="text/css" />
</head>