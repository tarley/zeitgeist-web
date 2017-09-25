<?php

class Jornal
{
    var $idJornal;
    var $idUsuario;
    var $idSituacao;
    var $nomTituloJornal;
    var $numEdicaoJornal;
    var $dtaPublicacaoJornal;
    var $dtaUltimaAtualizacaoJornal;
    var $descSituacao;
    var $valorPaginaImagem;
    var $paginas;

    function FillByObject($obj)
    {
        if (property_exists($obj, 'idJornal'))
            $this->idJornal = $obj->idJornal;

        if (property_exists($obj, 'idUsuario'))
            $this->idUsuario = $obj->idUsuario;

        if (property_exists($obj, 'idSituacao'))
            $this->idSituacao = $obj->idSituacao;

        if (property_exists($obj, 'nomTituloJornal'))
            $this->nomTituloJornal = $obj->nomTituloJornal;
       
        if (property_exists($obj, 'numEdicaoJornal'))
            $this->numEdicaoJornal = $obj->numEdicaoJornal;

        if (property_exists($obj, 'dtaPublicacaoJornal'))
            $this->dtaPublicacaoJornal = $obj->dtaPublicacaoJornal;

        if (property_exists($obj, 'dtaUltimaAtualizacaoJornal'))
            $this->dtaUltimaAtualizacaoJornal = $obj->dtaUltimaAtualizacaoJornal;
        
        if (property_exists($obj, 'descSituacao'))
            $this->descSituacao = $obj->descSituacao;
            
        if (property_exists($obj, 'valorPaginaImagem'))
            $this->valorPaginaImagem = $obj->valorPaginaImagem;    
      
        if (property_exists($obj, 'paginas')) {
            $this->paginas = array();

            foreach ($obj->paginas as $pagina) {
                $modelPagina = new Pagina();
                $modelPagina->FillByObject($pagina);

                $this->paginas[] = $modelPagina;
            }
        }
    }

    function FillByDB($dbArray)
    {
        if (array_key_exists("id_jornal", $dbArray))
            $this->idJornal = $dbArray['id_jornal'];

        if (array_key_exists("id_usuario", $dbArray))
            $this->idUsuario = $dbArray['id_usuario'];

        if (array_key_exists("id_situacao", $dbArray))
            $this->idSituacao = $dbArray['id_situacao'];
    
         if (array_key_exists("nom_titulo_jornal", $dbArray))
            $this->nomTituloJornal = $dbArray['nom_titulo_jornal'];
            
         if (array_key_exists("num_edicao_jornal", $dbArray))
            $this->numEdicaoJornal = $dbArray['num_edicao_jornal'];
            
         if (array_key_exists("dta_publicacao_jornal", $dbArray))
            $this->dtaPublicacaoJornal = $dbArray['dta_publicacao_jornal'];
        
        if (array_key_exists("dta_ultima_atualizacao_jornal", $dbArray))
            $this->dtaUltimaAtualizacaoJornal = $dbArray['dta_ultima_atualizacao_jornal'];
        
        if (array_key_exists("desc_situacao", $dbArray))
            $this->descSituacao = $dbArray['desc_situacao'];
            
        if (array_key_exists("valor_pagina_imagem", $dbArray))
            $this->valorPaginaImagem = base64_encode($dbArray['valor_pagina_imagem']);  
            
        $this->paginas = array();
        
        $paginaRepository = new PaginaRepository();
        $result = $paginaRepository->GetList($this->idJornal);

        foreach ($result as $dbPagina) {
            $modelPagina = new Pagina();
            $modelPagina->FillByDB($dbPagina);
            $this->paginas[] = $modelPagina;
        }
    }
}