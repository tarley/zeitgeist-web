<?php

class Pagina
{
    var $idPagina;
    var $idJornal;
    var $idTemplate;
    var $numPagina;
    var $nomPagina;

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

        if (array_key_exists("nom_pagina", $dbArray))
            $this->nomPagina = $dbArray['nom_pagina'];
    }
}