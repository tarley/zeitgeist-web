<?php

class JornalController extends BaseController
{
    function ProcessRequest($action)
    {
        try {
            switch ($action) {
                case "list":
                    $idSituacao = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionGetList($idSituacao);
                    break;
                case "insert":
                    $data = file_get_contents("php://input");
                    $this->ActionInsert($data);
                    break;
                 case "get":
                    $idJornal = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionGetThis($idJornal);
                    break;
                case "getMobile":
                    $this->ActionGetMobileVersion();
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

   

    function ActionGetList($idSituacao)
    {
        $jornalRepository = new JornalRepository();
        $result = $jornalRepository->GetList($idSituacao);

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

    function ActionGetMobileVersion()
    {
        $jornalRepository = new JornalRepository();
        $result = $jornalRepository->GetThisMobile();

        $jornal = new JornalMobile();
        $jornal->FillByDB($result);
    
        if (!$jornal->idJornal)
            throw new Warning("Jornal não encontrado");
            
         $jornalArray = (array)$jornal;
         
        foreach ($jornalArray['listaPaginas'] as $value){
            
            $paginaDadoRepository = new PaginaDadoRepository();
            $listaPaginaDado = $paginaDadoRepository->GetListMobile($value['idPagina']);
        
            $listPaginaDado = array();
    
            foreach ($listaPaginaDado as $dbPaginaDado) {
                $modelPaginaDado = new PaginaDado();
                $modelPaginaDado->FillByDB($dbPaginaDado);
                $listPaginaDado[] = $modelPaginaDado;
            }
        
            foreach ($listPaginaDado as $value1){
                $jornalArray[$value][$value1['chave_template_dado']] = [$value1['ValorMetadado']];
            }
        }
        
        echo $jornalArray;
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
