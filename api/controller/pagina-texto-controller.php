<?php

class PaginaTextoController extends BaseController
{
    function ProcessRequest($action)
    {
        try {
            switch ($action) {
                case "get":
                    $idPaginaTexto = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionGetThis($idPaginaTexto);
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
                    $idPaginaTexto = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionDelete($idPaginaTexto);
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

    function ActionGetThis($idPaginaTexto)
    {
        $paginaTextoRepository = new PaginaTextoRepository();
        $result = $paginaTextoRepository->GetThis($idPaginaTexto);

        $paginaTexto = new PaginaTexto();
        $paginaTexto->FillByDB($result);

        if (!$paginaTexto->idPaginaTexto)
            throw new Warning("Página Texto não encontrada");

        ToWrappedJson($paginaTexto);
    }

    function ActionGetList($idPaginaDado)
    {
        $paginaTextoRepository = new PaginaTextoRepository();
        $result = $paginaTextoRepository->GetList($idPaginaDado);

        $listPaginaTexto = array();

        foreach ($result as $dbPaginaTexto) {
            $modelPaginaTexto = new PaginaTexto();
            $modelPaginaTexto->FillByDB($dbPaginaTexto);
            $listPaginaTexto[] = $dbPaginaTexto;
        }

        ToWrappedJson($listPaginaTexto);
    }

    function ActionInsert($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $paginaTexto = new PaginaTexto();
        $paginaTexto->FillByObject($obj);

        $paginaTextoRepository = new PaginaTextoRepository();
        $paginaTextoRepository->Insert($paginaTexto);

        ToWrappedJson($paginaTexto, "Página Texto inserida com sucesso");
    }

    function ActionUpdate($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $paginaTexto = new PaginaTexto();
        $paginaTexto->FillByObject($obj);

        $paginaTextoRepository = new PaginaTextoRepository();
        $paginaTextoRepository->Update($paginaTexto);

        ToWrappedJson($paginaTexto, "Dados atualizados com sucesso");
    }
    
    function ActionDelete($idPaginaTexto)
    {
        $paginaTextoRepository = new PaginaTextoRepository();
        $result = $paginaTextoRepository->Delete($idPaginaTexto);

        if(!$result)
            throw new Warning("Falha ao excluir Página Texto.");

        ToWrappedJson("{}", "Página Texto excluida com sucesso");
    }
}
