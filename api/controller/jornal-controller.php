<?php

class JornalController extends BaseController
{
    function ProcessRequest($action)
    {
        try {
            switch ($action) {
                case "list":
                    $this->ActionGetList();
                    break;
                case "insert":
                    $data = file_get_contents("php://input");
                    $this->ActionInsert($data);
                    break;
                 case "get":
                    $idJornal = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionGetThis($idJornal);
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

   

    function ActionGetList()
    {
        $jornalRepository = new JornalRepository();
        $result = $jornalRepository->GetList();

        $listJornal = array();

        foreach ($result as $dbJornal) {
            $modelJornal = new Jornal();
            $modelJornal->FillByDB($dbJornal);
            $listJornal[] = $modelJornal;
        }

        ToWrappedJson($listJornal);
    }

    function ActionGetThis($idJornal)
    {
        $jornalRepository = new JornalRepository();
        $result = $jornalRepository->GetThis($idJornal);

        $jornal = new Jornal();
        $jornal->FillByDB($result);

        if (!$jornal->idJornal)
            throw new Warning("Jornal não encontrado");

        ToWrappedJson($jornal);
    }



    function ActionInsert($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $jornal = new Jornal();
        $jornal->FillByObject($obj);

        $jornalRepository = new JornalRepository();
        $jornalRepository->Insert($jornal);

        ToWrappedJson($jornal, "Jornal inserido com sucesso");
    }
            //CREATE UPDATE
            //IN PROGRESS.....

   
}
