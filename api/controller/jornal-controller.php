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
                case "listToApp":
                    $this->ActionGetListToApp();
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
    
    function ActionGetListToApp()
    {
        $jornalRepository = new JornalRepository();
        $paginaRepository = new PaginaRepository();
        $paginaDadoRepository = new PaginaDadoRepository();
        
        $paginaStringRepository = new PaginaStringRepository();
        $paginaTextoRepository = new PaginaTextoRepository();
        $paginaImagemRepository = new PaginaImagemRepository();
        
        $jornal = $jornalRepository->GetLastPublish();
        $jornal['paginas'] = $paginaRepository->GetList($jornal['id_jornal']);
        
        foreach($jornal['paginas'] as $key => $value) {
            $dadosPagina = $paginaDadoRepository->GetList($value['id_pagina']);
            
            $metadados = array();
            
            
            foreach($dadosPagina as $dado) {
                if($dado['id_tipo_template_dado'] == 1) {
                    $string = $paginaStringRepository->Get($dado['id_pagina_dado']);
                    $valor = $string['valor_pagina_string'];
                } elseif($dado['id_tipo_template_dado'] == 2) {
                    $texto = $paginaTextoRepository->Get($dado['id_pagina_dado']);
                    $valor = $texto['valor_pagina_texto'];
                } elseif($dado['id_tipo_template_dado'] == 3) {
                    $imagem = $paginaImagemRepository->Get($dado['id_pagina_dado']);
                    
                    $valor = 'data:image/' . $imagem['tipo'] . ';base64, ' . 
                        base64_encode($imagem['valor_pagina_imagem']);
                } else
                    $valor = null;
                     
                $metadados[$dado['chave_template_dado']] = $valor;
            }
            
            $jornal['paginas'][$key]['metadados'] = $metadados;
        }

        /*foreach ($result as $dbJornal) {
            $modelJornal = new Jornal();
            $modelJornal->FillByDB($dbJornal);
            $listJornal[] = $modelJornal;
        }*/

        ToWrappedJson($jornal);
    }
            //CREATE UPDATE
            //IN PROGRESS.....

   
}
