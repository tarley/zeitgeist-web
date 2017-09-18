<?php

class PaginaTexto
{
    var $idPaginaTexto;
    var $idPaginaDado;
    var $valorPaginaTexto;

    function FillByObject($obj)
    {
        if (property_exists($obj, 'idPaginaTexto'))
            $this->idPaginaTexto = $obj->idPaginaTexto;

        if (property_exists($obj, 'idPaginaDado'))
            $this->idPaginaDado = $obj->idPaginaDado;

        if (property_exists($obj, 'valorPaginaTexto'))
            $this->valorPaginaTexto = $obj->valorPaginaTexto;
    }

    function FillByDB($dbArray)
    {
        if (array_key_exists("id_pagina_texto", $dbArray))
            $this->idPaginaTexto = $dbArray['id_pagina_texto'];

        if (array_key_exists("id_pagina_dado", $dbArray))
            $this->idPaginaDado = $dbArray['id_pagina_dado'];

        if (array_key_exists("valor_pagina_texto", $dbArray))
            $this->valorPaginaTexto = $dbArray['valor_pagina_texto'];
    }
}