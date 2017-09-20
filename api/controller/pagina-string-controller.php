<?php

class PaginaStringController extends BaseController
{
    function ProcessRequest($action)
    {
        try {
            switch ($action) {
                case "get":
                    $idPaginaString = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionGetThis($idPaginaString);
                    break;
                case "list":
                    $idPaginaDado = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionGetList($idPaginaDado);
                    break;
                case "insert":
                    $data = file_get_contents("php://input");
                    $this->ActionInsert($data);
                    break;
                case "update":
                    $data = file_get_contents("php://input");
                    $this->ActionUpdate($data);
                    break;
                case "delete":
                    $idPaginaString = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionDelete($idPaginaString);
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

    function ActionGetThis($idPaginaString)
    {
        $paginaStringRepository = new PaginaStringRepository();
        $result = $paginaStringRepository->GetThis($idPaginaString);

        $paginaString = new PaginaString();
        $paginaString->FillByDB($result);

        if (!$paginaString->idPaginaString)
            throw new Warning("Página String não encontrada");

        ToWrappedJson($paginaString);
    }

    function ActionGetList($idPaginaDado)
    {
        $paginaStringRepository = new PaginaStringRepository();
        $result = $paginaStringRepository->GetList($idPaginaDado);

        $listPaginaString = array();

        foreach ($result as $dbPaginaString) {
            $modelPaginaString = new PaginaString();
            $modelPaginaString->FillByDB($dbPaginaString);
            $listPaginaString[] = $dbPaginaString;
        }

        ToWrappedJson($listPaginaString);
    }

    function ActionInsert($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $paginaString = new PaginaString();
        $paginaString->FillByObject($obj);

        $paginaStringRepository = new PaginaStringRepository();
        $paginaStringRepository->Insert($paginaString);

        ToWrappedJson($paginaString, "Página String inserida com sucesso");
    }

    function ActionUpdate($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $paginaString = new PaginaString();
        $paginaString->FillByObject($obj);

        $paginaStringRepository = new PaginaStringRepository();
        $paginaStringRepository->Update($paginaString);

        ToWrappedJson($paginaString, "Dados atualizados com sucesso");
    }
    
    function ActionDelete($idPaginaString)
    {
        $paginaStringRepository = new PaginaStringRepository();
        $result = $paginaStringRepository->Delete($idPaginaString);

        if(!$result)
            throw new Warning("Falha ao excluir Página String.");

        ToWrappedJson("{}", "Página String excluida com sucesso");
    }
}
