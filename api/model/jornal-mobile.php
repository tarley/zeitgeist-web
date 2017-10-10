<?php

class JornalMobile
{
    var $idJornal;
    var $nomTituloJornal;
    var $numEdicaoJornal;
    var $dtaPublicacaoJornal;
    var $dtaUltimaAtualizacaoJornal;
    var $listaPaginas;

    function FillByObject($obj)
    {
        if (property_exists($obj, 'idJornal'))
            $this->idJornal = $obj->idJornal;

        if (property_exists($obj, 'nomTituloJornal'))
            $this->nomTituloJornal = $obj->nomTituloJornal;
       
        if (property_exists($obj, 'numEdicaoJornal'))
            $this->numEdicaoJornal = $obj->numEdicaoJornal;

        if (property_exists($obj, 'dtaPublicacaoJornal'))
            $this->dtaPublicacaoJornal = $obj->dtaPublicacaoJornal;

        if (property_exists($obj, 'dtaUltimaAtualizacaoJornal'))
            $this->dtaUltimaAtualizacaoJornal = $obj->dtaUltimaAtualizacaoJornal;
        
        if (property_exists($obj, 'listaPaginas')) {
            $this->listaPaginas = array();

            foreach ($obj->listaPaginas as $pagina) {
                $modelPagina = new Pagina();
                $modelPagina->FillByObject($pagina);

                $this->listaPaginas[] = $modelPagina;
            }
        }
    }

    function FillByDB($dbArray)
    {
        if (array_key_exists("id_jornal", $dbArray))
            $this->idJornal = $dbArray['id_jornal'];

         if (array_key_exists("nom_titulo_jornal", $dbArray))
            $this->nomTituloJornal = $dbArray['nom_titulo_jornal'];
            
         if (array_key_exists("num_edicao_jornal", $dbArray))
            $this->numEdicaoJornal = $dbArray['num_edicao_jornal'];
            
         if (array_key_exists("dta_publicacao_jornal", $dbArray))
            $this->dtaPublicacaoJornal = $dbArray['dta_publicacao_jornal'];
        
        if (array_key_exists("dta_ultima_atualizacao_jornal", $dbArray))
            $this->dtaUltimaAtualizacaoJornal = $dbArray['dta_ultima_atualizacao_jornal'];
        
        $this->listaPaginas = array();
        
        $paginaRepository = new PaginaRepository();
        $result = $paginaRepository->GetList($this->idJornal);

        foreach ($result as $dbPagina) {
            $modelPagina = new Pagina();
            $modelPagina->FillByDB($dbPagina);
            $this->listaPaginas[] = $modelPagina;
        }
    }
}