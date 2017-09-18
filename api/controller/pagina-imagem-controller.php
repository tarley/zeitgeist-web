<?php

class PaginaImagemController extends BaseController
{
    function ProcessRequest($action)
    {
        try {
            switch ($action) {
                case "get":
                    $idPaginaImagem = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionGetThis($idPaginaImagem);
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
                    $idPaginaImagem = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionDelete($idPaginaImagem);
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

    function ActionGetThis($idPaginaImagem)
    {
        $paginaImagemRepository = new PaginaImagemRepository();
        $result = $paginaImagemRepository->GetThis($idPaginaImagem);

        $paginaImagem = new PaginaImagem();
        $paginaImagem->FillByDB($result);

        if (!$paginaImagem->idPaginaImagem)
            throw new Warning("Página Imagem não encontrada");

        ToWrappedJson($paginaImagem);
    }

    function ActionGetList($idPaginaDado)
    {
        $paginaImagemRepository = new PaginaImagemRepository();
        $result = $paginaImagemRepository->GetList($idPaginaDado);

        $listPaginaImagem = array();

        foreach ($result as $dbPaginaImagem) {
            $modelPaginaImagem = new PaginaImagem();
            $modelPaginaImagem->FillByDB($dbPaginaImagem);
            $listPaginaImagem[] = $dbPaginaImagem;
        }

        ToWrappedJson($listPaginaImagem);
    }

    function ActionInsert($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $paginaImagem = new PaginaImagem();
        $paginaImagem->FillByObject($obj);

        $paginaImagemRepository = new PaginaImagemRepository();
        $paginaImagemRepository->Insert($paginaImagem);

        ToWrappedJson($paginaImagem, "Página Imagem inserida com sucesso");
    }

    function ActionUpdate($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $paginaImagem = new PaginaImagem();
        $paginaImagem->FillByObject($obj);

        $paginaImagemRepository = new PaginaImagemRepository();
        $paginaImagemRepository->Update($paginaImagem);

        ToWrappedJson($paginaImagem, "Dados atualizados com sucesso");
    }
    
    function ActionDelete($idPaginaImagem)
    {
        $paginaImagemRepository = new PaginaImagemRepository();
        $result = $paginaImagemRepository->Delete($idPaginaImagem);

        if(!$result)
            throw new Warning("Falha ao excluir Página Imagem.");

        ToWrappedJson("{}", "Página Imagem excluida com sucesso");
    }
}
