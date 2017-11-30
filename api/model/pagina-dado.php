<?php

class PaginaDado
{
    var $idPaginaDado;
    var $idPagina;
    var $idTemplateDado;
    var $idTipoTemplateDado;
    var $chaveTemplateDado;
    var $descTemplateDado;
    var $valorPaginaDado;

    function FillByObject($obj)
    {
        if (property_exists($obj, 'idPaginaDado'))
            $this->idPaginaDado = $obj->idPaginaDado;

        if (property_exists($obj, 'idPagina'))
            $this->idPagina = $obj->idPagina;

        if (property_exists($obj, 'idTemplateDado'))
            $this->idTemplateDado = $obj->idTemplateDado;

		if (property_exists($obj, 'idTipoTemplateDado'))
			$this->idTipoTemplateDado = $obj->idTipoTemplateDado;

		if (property_exists($obj, 'valorPaginaDado'))
			$this->valorPaginaDado = $obj->valorPaginaDado;
    }

    function FillByDB($dbArray)
    {
        if (array_key_exists("id_pagina_dado", $dbArray))
            $this->idPaginaDado = $dbArray['id_pagina_dado'];

        if (array_key_exists("id_pagina", $dbArray))
            $this->idPagina = $dbArray['id_pagina'];

        if (array_key_exists("id_template_dado", $dbArray))
            $this->idTemplateDado = $dbArray['id_template_dado'];

        if (array_key_exists("id_tipo_template_dado", $dbArray))
            $this->idTipoTemplateDado = $dbArray['id_tipo_template_dado'];

        if (array_key_exists("chave_template_dado", $dbArray))
            $this->chaveTemplateDado = $dbArray['chave_template_dado'];

        if (array_key_exists("desc_template_dado", $dbArray))
            $this->descTemplateDado = $dbArray['desc_template_dado'];

        if (array_key_exists("valor_pagina_dado", $dbArray)) {
			$this->valorPaginaDado = $dbArray['valor_pagina_dado'];
		}
    }
}