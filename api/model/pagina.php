<?php

class Pagina
{
    var $idPagina;
    var $idJornal;
    var $idTemplate;
    var $numPagina;
    var $nomPagina;
    var $paginaDado;
    var $dadosTemplate;
    var $primeiraPagina;
    var $ultimaPagina;

    function FillByObject($obj)
    {
        if (property_exists($obj, 'idPagina'))
            $this->idPagina = $obj->idPagina;

        if (property_exists($obj, 'idJornal'))
            $this->idJornal = $obj->idJornal;

        if (property_exists($obj, 'idTemplate'))
            $this->idTemplate = $obj->idTemplate;

        if (property_exists($obj, 'numPagina'))
            $this->numPagina = $obj->numPagina;

        if (property_exists($obj, 'nomPagina'))
            $this->nomPagina = $obj->nomPagina;

        if (property_exists($obj, 'paginaDado')) {
            $this->paginaDado = array();

            foreach ($obj->paginaDado as $paginaDado) {
                $modelPaginaDado = new PaginaDado();
                $modelPaginaDado->FillByObject($paginaDado);

                $this->paginaDado[] = $modelPaginaDado;
            }
        }
        
        if (property_exists($obj, 'dadosTemplate')) {
            $this->dadosTemplate = array();

            foreach ($obj->dadosTemplate as $dadosTemplate) {
                $modelDadosTemplate = new DadosTemplate();
                $modelDadosTemplate->FillByObject($paginaDado);

                $this->dadosTemplate[] = $modelDadosTemplate;
            }
        }
    }

    function FillByDB($dbArray)
    {
        if (array_key_exists("id_pagina", $dbArray))
            $this->idPagina = $dbArray['id_pagina'];

        if (array_key_exists("id_jornal", $dbArray))
            $this->idJornal = $dbArray['id_jornal'];

        if (array_key_exists("id_template", $dbArray))
            $this->idTemplate = $dbArray['id_template'];

        if (array_key_exists("num_pagina", $dbArray))
            $this->numPagina = $dbArray['num_pagina'];
            
        if ($this->numPagina == 1) {
            $this->primeiraPagina = true;
            $this->ultimaPagina = false;
        } else if(array_key_exists("qtd_paginas_jornal", $dbArray) && $this->numPagina == $dbArray['qtd_paginas_jornal']) {
            $this->primeiraPagina = false;
            $this->ultimaPagina = true;
        }
            
        if (array_key_exists("nom_pagina", $dbArray))
            $this->nomPagina = $dbArray['nom_pagina'];

        if (array_key_exists("pagina_dado", $dbArray)) {
            $this->paginaDado = array();

            foreach ($dbArray["pagina_dado"] as $dbPaginaDado) {
                $modelPaginaDado = new PaginaDado();
                $modelPaginaDado->FillByDB($dbPaginaDado);
                $this->paginaDado[] = $modelPaginaDado;
            }
        }

//        $this->dadosTemplate = array();
//
//        $dadosTemplateRepository = new DadosTemplateRepository();
//        $result = $dadosTemplateRepository->GetList($this->idTemplate);
//
//        foreach ($result as $dbDadosTemplate) {
//            $modelDadosTemplate = new DadosTemplate();
//            $modelDadosTemplate->FillByDB($dbDadosTemplate);
//            $this->dadosTemplate[] = $modelDadosTemplate;
//        }
    }
}