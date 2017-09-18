<?php

class PaginaDadoController extends BaseController
{
    function ProcessRequest($action)
    {
        try {
            switch ($action) {
                case "get":
                    $idPaginaDado = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionGetThis($idPaginaDado);
                    break;
                case "list":
                    $idPagina = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionGetList($idPagina);
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
                    $idPaginaDado = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionDelete($idPaginaDado);
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

    function ActionGetThis($idPaginaDado)
    {
        $paginaDadoRepository = new PaginaDadoRepository();
        $result = $paginaDadoRepository->GetThis($idPaginaDado);

        $paginaDado = new PaginaDado();
        $paginaDado->FillByDB($result);

        if (!$paginaDado->idPaginaDado)
            throw new Warning("Página Dado não encontrada");

        ToWrappedJson($paginaDado);
    }

    function ActionGetList($idPagina)
    {
        $paginaDadoRepository = new PaginaDadoRepository();
        $result = $paginaDadoRepository->GetList($idPagina);

        $listPaginaDado = array();

        foreach ($result as $dbPaginaDado) {
            $modelPaginaDado = new PaginaDado();
            $modelPaginaDado->FillByDB($dbPaginaDado);
            $listPaginaDado[] = $modelPaginaDado;
        }

        ToWrappedJson($listPaginaDado);
    }

    function ActionInsert($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $paginaDado = new PaginaDado();
        $paginaDado->FillByObject($obj);

        $paginaDadoRepository = new PaginaDadoRepository();
        $paginaDadoRepository->Insert($paginaDado);

        ToWrappedJson($paginaDado, "Página Dado inserida com sucesso");
    }

    function ActionUpdate($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $paginaDado = new PaginaDado();
        $paginaDado->FillByObject($obj);

        $paginaDadoRepository = new PaginaDadoRepository();
        $paginaDadoRepository->Update($paginaDado);

        ToWrappedJson($paginaDado, "Dados atualizados com sucesso");
    }
    
    function ActionDelete($idPaginaDado)
    {
        $paginaDadoRepository = new PaginaDadoRepository();
        $result = $paginaDadoRepository->Delete($idPaginaDado);

        if(!$result)
            throw new Warning("Falha ao excluir Página Dado.");

        ToWrappedJson("{}", "Página Dado excluido com sucesso");
    }
}
