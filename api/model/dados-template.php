<?php

class DadosTemplate
{
    var $idTemplateDado;
    var $idTemplate;
    var $idTipoTemplateDado;
    var $chaveTemplateDado;
    var $descTemplateDado;
    
    function FillByObject($obj)
    {
        if (property_exists($obj, 'idTemplateDado'))
            $this->idTemplateDado = $obj->idTemplateDado;

        if (property_exists($obj, 'idTemplate'))
            $this->idTemplate = $obj->idTemplate;

        if (property_exists($obj, 'idTipoTemplateDado'))
            $this->idTipoTemplateDado = $obj->idTipoTemplateDado;

        if (property_exists($obj, 'chaveTemplateDado'))
            $this->chaveTemplateDado = $obj->chaveTemplateDado;

        if (property_exists($obj, 'descTemplateDado'))
            $this->descTemplateDado = $obj->descTemplateDado;

   
    }

    function FillByDB($dbArray)
    {
        if (array_key_exists("id_template_dado", $dbArray))
            $this->idTemplateDado = $dbArray['id_template_dado'];

        if (array_key_exists("id_template", $dbArray))
            $this->idTemplate = $dbArray['id_template'];

        if (array_key_exists("id_tipo_template_dado", $dbArray))
            $this->idTipoTemplateDado = $dbArray['id_tipo_template_dado'];

        if (array_key_exists("chave_template_dado", $dbArray))
            $this->chaveTemplateDado = $dbArray['chave_template_dado'];

        if (array_key_exists("desc_template_dado", $dbArray))
            $this->descTemplateDado = $dbArray['desc_template_dado'];

      

    }
}