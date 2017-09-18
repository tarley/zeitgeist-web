<?php

class TipoTemplateDado
{
    var $idSituacao;
    var $descSituacao;
    
  
    function FillByObject($obj)
    {
        if (property_exists($obj, 'idSituacao'))
            $this->idSituacao = $obj->idSituacao;

        if (property_exists($obj, 'descSituacao'))
            $this->descSituacao = $obj->descSituacao;

        
    }

    function FillByDB($dbArray)
    {
        if (array_key_exists("id_situacao", $dbArray))
            $this->idSituacao = $dbArray['id_situacao'];

        if (array_key_exists("desc_situacao", $dbArray))
            $this->descSituacao = $dbArray['desc_situacao'];


    }
}