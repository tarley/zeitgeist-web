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
                case "listCompleteToApp":
                    $this->ActionGetListCompleteToApp();
                    break;
                case "insert":
                    $data = file_get_contents("php://input");
                    $this->ActionInsert($data);
                    break;
                case "update":
                    $data = file_get_contents("php://input");
                    $this->ActionUpdate($data);
                    break;
                 case "get":
                    $idJornal = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionGetThis($idJornal);
                    break;
                case "getUltimaEdicao":
                    $this->ActionGetThisUltimaEdicao();
                    break;
                case "getMobile":
                    $this->ActionGetMobileVersion();
                    break;
                case "subirPagina":
                    $idPagina = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionSubirPagina($idPagina);
                    break;
                case "descerPagina":
                    $idPagina = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionDescerPagina($idPagina);
                    break;
                case "publicarJornal":
                    $idJornal = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionPublicar($idJornal);
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
    
    function ActionGetThisUltimaEdicao()
    {
        $jornalRepository = new JornalRepository();
        $result = $jornalRepository->GetThisUltimaEdicao();

        $jornal = new Jornal();
        $jornal->FillByDB($result);

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
                    
                    $valor = $imagem['valor_pagina_imagem_64'];
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
    
    function ActionGetListCompleteToApp()
    {
        $jornalRepository = new JornalRepository();
        $paginaRepository = new PaginaRepository();
        $paginaDadoRepository = new PaginaDadoRepository();
        
        $paginaStringRepository = new PaginaStringRepository();
        $paginaTextoRepository = new PaginaTextoRepository();
        $paginaImagemRepository = new PaginaImagemRepository();
        
        $listaJornal['jornal'] = $jornalRepository->GetEdicoesApp();
        
         foreach($listaJornal['jornal'] as $key1 => $value1) {
            $listaJornal['jornal'][$key1]['paginas'] = $paginaRepository->GetList($value1['id_jornal']);
            
            foreach($listaJornal['jornal'][$key1]['paginas'] as $key => $value) {
               
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
                        
                        $valor = $imagem['valor_pagina_imagem_64'];
                    } else
                        $valor = null;
                         
                    $metadados[$dado['chave_template_dado']] = $valor;
                }
                
                $listaJornal['jornal'][$key1]['paginas'][$key]['metadados'] = $metadados;
            }
        }

        /*foreach ($result as $dbJornal) {
            $modelJornal = new Jornal();
            $modelJornal->FillByDB($dbJornal);
            $listJornal[] = $modelJornal;
        }*/

        ToWrappedJson($listaJornal);
    }
            //CREATE UPDATE
            //IN PROGRESS.....
    function ActionUpdate($data)
    {
        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $jornal = new Jornal();
        $jornal->FillByObject($obj);

        $jornalRepository = new JornalRepository();
        $jornalRepository->Update($jornal);

        ToWrappedJson($jornal, "Dados atualizados com sucesso");
    }
    
    function ActionSubirPagina($idPagina)
    {
        $jornalRepository = new JornalRepository();
        $result = $jornalRepository->SubirPagina($idPagina);

        $listPaginas = array();

        foreach ($result as $dbPagina) {
            $modelPagina = new Pagina();
            $modelPagina->FillByDB($dbPagina);
            $listPaginas[] = $modelPagina;
        }

        ToWrappedJson($listPaginas);
    }
    
    function ActionDescerPagina($idPagina)
    {
        $jornalRepository = new JornalRepository();
        $result = $jornalRepository->DescerPagina($idPagina);

        $listPaginas = array();

        foreach ($result as $dbPagina) {
            $modelPagina = new Pagina();
            $modelPagina->FillByDB($dbPagina);
            $listPaginas[] = $modelPagina;
        }

        ToWrappedJson($listPaginas);
    }
    
    function ActionPublicar($idJornal)
    {
        $jornalRepository = new JornalRepository();
        $result = $jornalRepository->PublicarJornal($idJornal);
        
        $resultLista = $jornalRepository->GetList(null);

        $listJornal = array();

        foreach ($resultLista as $dbJornal) {
            $modelJornal = new Jornal();
            $modelJornal->FillByDB($dbJornal);
            $listJornal[] = $modelJornal;
        }

        ToWrappedJson($listJornal);
    }
   
}
