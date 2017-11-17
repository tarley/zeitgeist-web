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
    case "pagina":
        $pagina = new PaginaController();
        $pagina->ProcessRequest($action);
        break;
    case "paginaDado":
        $paginaDado = new PaginaDadoController();
        $paginaDado->ProcessRequest($action);
        break;
    case "paginaImagem":
        $paginaImagem = new PaginaImagemController();
        $paginaImagem->ProcessRequest($action);
        break;
    case "paginaString":
        $paginaString = new PaginaStringController();
        $paginaString->ProcessRequest($action);
        break;
    case "paginaTexto":
        $paginaTexto = new PaginaTextoController();
        $paginaTexto->ProcessRequest($action);
        break;
    case "dadosTemplate":
        $dadosTemplate = new DadosTemplateController();
        $dadosTemplate->ProcessRequest($action);
        break;
     case "jornal":
        $jornal = new JornalController();
        $jornal->ProcessRequest($action);
        break;
    case "situacao":
        $situacao = new SituacaoController();
        $situacao->ProcessRequest($action);
        break;
    case "template":
        $template = new TemplateController();
        $template->ProcessRequest($action);
        break;
    default:
        ToErrorJson("Controller not found");
}