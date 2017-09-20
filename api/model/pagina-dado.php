<?php

class PaginaDado
{
    var $idPaginaDado;
    var $idPagina;
    var $idTemplateDado;

    function FillByObject($obj)
    {
        if (property_exists($obj, 'idPaginaDado'))
            $this->idPaginaDado = $obj->idPaginaDado;

        if (property_exists($obj, 'idPagina'))
            $this->idPagina = $obj->idPagina;

        if (property_exists($obj, 'idTemplateDado'))
            $this->idTemplateDado = $obj->idTemplateDado;
    }

    function FillByDB($dbArray)
    {
        if (array_key_exists("id_pagina_dado", $dbArray))
            $this->idPaginaDado = $dbArray['id_pagina_dado'];

        if (array_key_exists("id_pagina", $dbArray))
            $this->idPagina = $dbArray['id_pagina'];

        if (array_key_exists("id_template_dado", $dbArray))
            $this->idTemplateDado = $dbArray['id_template_dado'];
    }
}