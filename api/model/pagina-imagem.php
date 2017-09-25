<?php

class PaginaImagem
{
    var $idPaginaImagem;
    var $idPaginaDado;
    var $valorPaginaImagem;

    function FillByObject($obj)
    {
        if (property_exists($obj, 'idPaginaImagem'))
            $this->idPaginaImagem = $obj->idPaginaImagem;

        if (property_exists($obj, 'idPaginaDado'))
            $this->idPaginaDado = $obj->idPaginaDado;

        if (property_exists($obj, 'valorPaginaImagem'))
            $this->valorPaginaImagem = $obj->valorPaginaImagem;
    }

    function FillByDB($dbArray)
    {
        if (array_key_exists("id_pagina_imagem", $dbArray))
            $this->idPaginaImagem = $dbArray['id_pagina_imagem'];

        if (array_key_exists("id_pagina_dado", $dbArray))
            $this->idPaginaDado = $dbArray['id_pagina_dado'];

        if (array_key_exists("valor_pagina_imagem", $dbArray))
            $this->valorPaginaImagem = base64_encode($dbArray['valor_pagina_imagem']);
    }
}