<?php

class PaginaController extends BaseController
{
    function ProcessRequest($action)
    {
        try {
            switch ($action) {
                case "get":
                    $idPagina = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionGetThis($idPagina);
                    break;
                case "list":
                    $idJornal = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionGetList($idJornal);
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
					$data = file_get_contents("php://input");
                    $this->ActionDelete($data);
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

    function ActionGetThis($idPagina)
    {
        $paginaRepository = new PaginaRepository();
        $result = $paginaRepository->GetThis($idPagina);

        $pagina = new Pagina();
        $pagina->FillByDB($result);

        if (!$pagina->idPagina)
            throw new Warning("Página não encontrada");

        ToWrappedJson($pagina);
    }

    function ActionGetList($idJornal)
    {
        $paginaRepository = new PaginaRepository();
        $result = $paginaRepository->GetList($idJornal);

        $listPagina = array();

        foreach ($result as $dbPagina) {
            $modelPagina = new Pagina();
            $modelPagina->FillByDB($dbPagina);
            $listPagina[] = $modelPagina;
        }

        ToWrappedJson($listPagina);
    }

    function ActionInsert($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $pagina = new Pagina();
        $pagina->FillByObject($obj);

        $paginaRepository = new PaginaRepository();
        $paginaRepository->Insert($pagina);

        ToWrappedJson($pagina, "Página inserida com sucesso");
    }

    function ActionUpdate($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $pagina = new Pagina();
        $pagina->FillByObject($obj);

        $paginaRepository = new PaginaRepository();
        $paginaRepository->Update($pagina);

        ToWrappedJson($pagina, "Dados atualizados com sucesso");
    }
    
    function ActionDelete($data)
    {
		if (!$data) {
			throw new Warning("Os dados enviados são inválidos");
		}

		$obj = json_decode($data);

		$pagina = new Pagina();
		$pagina->FillByObject($obj);

        $paginaRepository = new PaginaRepository();
        $result = $paginaRepository->Delete($pagina);

		$listPaginas = array();

		foreach ($result as $dbPagina) {
			$modelPagina = new Pagina();
			$modelPagina->FillByDB($dbPagina);
			$listPaginas[] = $modelPagina;
		}

		ToWrappedJson($listPaginas, "Página excluida com sucesso");
    }
}
