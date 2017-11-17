<?php

class Template
{
    var $idTemplate;
    var $descTemplate;
    var $descCaminhoTemplate;
	var $dadosTemplate;

    function FillByObject($obj)
    {
        if (property_exists($obj, 'idTemplate'))
            $this->idTemplate = $obj->idTemplate;

        if (property_exists($obj, 'descTemplate'))
            $this->descTemplate = $obj-> descTemplate;

        if (property_exists($obj, 'descCaminhoTemplate'))
            $this->descCaminhoTemplate = $obj->descCaminhoTemplate;
    }

    function FillByDB($dbArray)
    {
        if (array_key_exists("id_template", $dbArray))
            $this->idTemplate = $dbArray['id_template'];

        if (array_key_exists("desc_Template", $dbArray))
            $this->descTemplate = $dbArray['desc_Template'];

        if (array_key_exists("desc_caminho_template", $dbArray))
            $this->descCaminhoTemplate = $dbArray['desc_caminho_template'];

		if (array_key_exists("dadosTemplate", $dbArray)) {
			foreach ($dbArray["dadosTemplate"] as $dbDadoTemplate) {
				$dado = new DadosTemplate();
				$dado->FillByDB($dbDadoTemplate);

				$this->dadosTemplate[] = $dado;
			}
		}
    }
}