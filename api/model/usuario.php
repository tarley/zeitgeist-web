<?php

class Usuario
{
    var $idUsuario;
    var $nomUsuario;
    var $emailUsuario;
    var $senhaUsuario;
    var $idPerfil;
    var $perfil;
	var $inativo;

    function FillByObject($obj)
    {
        if (property_exists($obj, 'idUsuario'))
            $this->idUsuario = $obj->idUsuario;

        if (property_exists($obj, 'nomUsuario'))
            $this->nomUsuario = $obj->nomUsuario;

        if (property_exists($obj, 'emailUsuario'))
            $this->emailUsuario = $obj->emailUsuario;
        elseif(property_exists($obj, 'login'))
            $this->emailUsuario = $obj->login;

        if (property_exists($obj, 'senhaUsuario'))
            $this->senhaUsuario = $obj->senhaUsuario;
        elseif (property_exists($obj, 'senha'))
            $this->senhaUsuario = $obj->senha;

		if (property_exists($obj, 'inativo'))
			$this->inativo = $obj->inativo;
    }

    function FillByDB($dbArray)
    {
        if (array_key_exists("id_usuario", $dbArray))
            $this->idUsuario = $dbArray['id_usuario'];

        if (array_key_exists("nom_usuario", $dbArray))
            $this->nomUsuario = $dbArray['nom_usuario'];

        if (array_key_exists("email_usuario", $dbArray))
            $this->emailUsuario = $dbArray['email_usuario'];
        
        if (array_key_exists("id_perfil_usuario", $dbArray))
            $this->idPerfil = $dbArray['id_perfil_usuario'];
            
        if (array_key_exists("nome_perfil", $dbArray))
            $this->perfil = $dbArray['nome_perfil'];

		if (array_key_exists("inativo_usuario", $dbArray))
			$this->inativo = $dbArray['inativo_usuario'];

        $this->senhaUsuario = "";
    }
}