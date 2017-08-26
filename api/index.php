<?php

session_start();

//General Include
require_once "includes.php";

require_once "model/_includes.php";
require_once "controller/_includes.php";
require_once "repository/_includes.php";

$controller = isset($_GET['controller']) ? $_GET['controller'] : (isset($_POST['controller']) ? $_POST['controller'] : "");
$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : "");

if (!$controller || !$action) {
    ToErrorJson("Request not found.");
}

if(ENV != 'Dev' && ($controller != 'usuario' || $action != 'login')) {

    if (!isset($_SERVER['PHP_AUTH_USER']) ||
        !isset($_SERVER['PHP_AUTH_PW']) ||
        !isset($_SESSION['authData']) ||
        base64_encode($_SERVER['PHP_AUTH_USER'].':'.$_SERVER['PHP_AUTH_PW']) != $_SESSION['authData'])
    {
        header('HTTP/1.0 401 Unauthorized');
        ToErrorJson("Access Denied.");
    }
}

switch ($controller){
    case "usuario":
        $usuario = new UsuarioController();
        $usuario->ProcessRequest($action);
        break;
    default:
        ToErrorJson("Controller not found");
}