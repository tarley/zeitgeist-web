<?php

class PaginaDado
{
    var $idPaginaDado;
    var $idPagina;
    var $idTemplateDado;
    /*var $paginaImagem;
    var $paginaString;
    var $paginaTexto;*/

    function FillByObject($obj)
    {
        if (property_exists($obj, 'idPaginaDado'))
            $this->idPaginaDado = $obj->idPaginaDado;

        if (property_exists($obj, 'idPagina'))
            $this->idPagina = $obj->idPagina;

        if (property_exists($obj, 'idTemplateDado'))
            $this->idTemplateDado = $obj->idTemplateDado;
            
        /*if (property_exists($obj, 'paginaImagem')) {
            $this->paginaImagem = array();

            foreach ($obj->paginaImagem as $paginaImagem) {
                $modelPaginaImagem = new PaginaImagem();
                $modelPaginaImagem->FillByObject($paginaImagem);

                $this->paginaImagem[] = $modelPaginaImagem;
            }
        }
        
        if (property_exists($obj, 'paginaString')) {
            $this->paginaString = array();

            foreach ($obj->paginaString as $paginaString) {
                $modelPaginaString = new PaginaString();
                $modelPaginaString->FillByObject($paginaString);

                $this->paginaString[] = $modelPaginaString;
            }
        }
        
        if (property_exists($obj, 'paginaTexto')) {
            $this->paginaTexto = array();

            foreach ($obj->paginaTexto as $paginaTexto) {
                $modelPaginaTexto = new PaginaTexto();
                $modelPaginaTexto->FillByObject($paginaTexto);

                $this->paginaTexto[] = $modelPaginaTexto;
            }
        }*/
    }

    function FillByDB($dbArray)
    {
        if (array_key_exists("id_pagina_dado", $dbArray))
            $this->idPaginaDado = $dbArray['id_pagina_dado'];

        if (array_key_exists("id_pagina", $dbArray))
            $this->idPagina = $dbArray['id_pagina'];

        if (array_key_exists("id_template_dado", $dbArray))
            $this->idTemplateDado = $dbArray['id_template_dado'];
            
        /*$this->paginaImagem = array();
        
        $paginaImagemRepository = new PaginaImagemRepository();
        $result = $paginaImagemRepository->GetList($this->idPaginaDado);

        foreach ($result as $dbPaginaImagem) {
            $modelPaginaImagem = new PaginaImagem();
            $modelPaginaImagem->FillByDB($dbPaginaImagem);
            $this->paginaImagem[] = $modelPaginaImagem;
        }
        
        $this->paginaString = array();
        
        $paginaStringRepository = new PaginaStringRepository();
        $result = $paginaStringRepository->GetList($this->idPaginaDado);

        foreach ($result as $dbPaginaString) {
            $modelPaginaString = new PaginaString();
            $modelPaginaString->FillByDB($dbPaginaString);
            $this->paginaString[] = $modelPaginaString;
        }
        
        $this->paginaTexto = array();
        
        $paginaTextoRepository = new PaginaTextoRepository();
        $result = $paginaTextoRepository->GetList($this->idPaginaDado);

        foreach ($result as $dbPaginaTexto) {
            $modelPaginaTexto = new PaginaTexto();
            $modelPaginaTexto->FillByDB($dbPaginaTexto);
            $this->paginaTexto[] = $modelPaginaTexto;
        }*/
    }
}