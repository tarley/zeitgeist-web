<?php

class PaginaString
{
    var $idPaginaString;
    var $idPaginaDado;
    var $valorPaginaString;

    function FillByObject($obj)
    {
        if (property_exists($obj, 'idPaginaString'))
            $this->idPaginaString = $obj->idPaginaString;

        if (property_exists($obj, 'idPaginaDado'))
            $this->idPaginaDado = $obj->idPaginaDado;

        if (property_exists($obj, 'valorPaginaString'))
            $this->valorPaginaString = $obj->valorPaginaString;
    }

    function FillByDB($dbArray)
    {
        if (array_key_exists("id_pagina_string", $dbArray))
            $this->idPaginaString = $dbArray['id_pagina_string'];

        if (array_key_exists("id_pagina_dado", $dbArray))
            $this->idPaginaDado = $dbArray['id_pagina_dado'];

        if (array_key_exists("valor_pagina_string", $dbArray))
            $this->valorPaginaString = $dbArray['valor_pagina_string'];
    }
}