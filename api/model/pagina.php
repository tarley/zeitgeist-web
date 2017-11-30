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
	var $newIdTemplate;

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

			if ($obj->paginaDado && sizeof($obj->paginaDado) > 0) {
				foreach ($obj->paginaDado as $paginaDado) {
					$modelPaginaDado = new PaginaDado();
					$modelPaginaDado->FillByObject($paginaDado);
					$modelPaginaDado->idPagina = $this->idPagina;

					$this->paginaDado[] = $modelPaginaDado;
				}
			}
		}

		if (property_exists($obj, 'newIdTemplate'))
			$this->newIdTemplate = $obj->newIdTemplate;
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
                $this->paginaDado[$modelPaginaDado->idTemplateDado] = $modelPaginaDado;
            }
        }
    }
}