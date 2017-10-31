<?php

class UsuarioController extends BaseController
{
    function ProcessRequest($action)
    {
        Log::Debug('ProcessRequest:' . $action);
        
        try {
            switch ($action) {
                case "get":
                    $idUsuario = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionGetThis($idUsuario);
                    break;
                case "list":
                    $this->ActionGetList();
                    break;
                case "insert":
                    $data = file_get_contents("php://input");
                    $this->ActionInsert($data);
                    break;
                case "update":
                    $data = file_get_contents("php://input");
                    $this->ActionUpdate($data);
                    break;
                case "login":
                    $data = file_get_contents("php://input");
                    $this->ActionLogin($data);
                    break;
                default:
                    ToErrorJson("Action not found");
            }
        } catch (Warning $e) {
            ToErrorJson($e->getMessage());
        } catch (Exception $e) {
            ToExceptionJson($e);
        }
    }

    function ActionGetThis($idUsuario)
    {
        $usuarioRepository = new UsuarioRepository();
        $result = $usuarioRepository->GetThis($idUsuario);

        $usuario = new Usuario();
        $usuario->FillByDB($result);

        if (!$usuario->idUsuario)
            throw new Warning("Usuário não encontrado");

        ToWrappedJson($usuario);
    }

    function ActionGetList()
    {
        $usuarioRepository = new UsuarioRepository();
        $result = $usuarioRepository->GetList();

        $listUsuario = array();

        foreach ($result as $dbUsuario) {
            $modelUsuario = new Usuario();
            $modelUsuario->FillByDB($dbUsuario);
            $listUsuario[] = $modelUsuario;
        }

        ToWrappedJson($listUsuario);
    }

    function ActionInsert($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $usuario = new Usuario();
        $usuario->FillByObject($obj);

        $usuarioRepository = new UsuarioRepository();
        $usuarioRepository->Insert($usuario);

        ToWrappedJson($usuario, "Usuário inserido com sucesso");
    }

    function ActionUpdate($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $usuario = new Usuario();
        $usuario->FillByObject($obj);

        $usuarioRepository = new UsuarioRepository();
        $usuarioRepository->Update($usuario);

        ToWrappedJson($usuario, "Dados atualizados com sucesso");
    }

    function ActionLogin($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);
Log::Debug('Objeto do banco:' . print_r($obj, true));
        $usuario = new Usuario();
        $usuario->FillByObject($obj);
Log::Debug('Depois da conversão: ' . print_r($usuario, true));
        $authData = base64_encode($usuario->emailUsuario . ':' . $usuario->senhaUsuario);

        $usuarioRepository = new UsuarioRepository();
        $usuarioRepository->Login($usuario);

        $_SESSION['cod_usuario'] = $usuario->idUsuario;
        $_SESSION['nome'] = $usuario->nomUsuario;
        $_SESSION['authData'] = $authData;

        ToWrappedJson(null, "Usuário autenticado com sucesso");
    }
}
