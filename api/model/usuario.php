<?php

class Usuario
{
    var $idUsuario;
    var $nomUsuario;
    var $emailUsuario;
    var $senhaUsuario;

    function FillByObject($obj)
    {
        if (property_exists($obj, 'idUsuario'))
            $this->idUsuario = $obj->idUsuario;

        if (property_exists($obj, 'nomUsuario'))
            $this->nomUsuario = $obj->nomUsuario;

        if (property_exists($obj, 'emailUsuario'))
            $this->emailUsuario = $obj->emailUsuario;

        if (property_exists($obj, 'senhaUsuario'))
            $this->senhaUsuario = $obj->senhaUsuario;
    }

    function FillByDB($dbArray)
    {
        if (array_key_exists("id_usuario", $dbArray))
            $this->idUsuario = $dbArray['id_usuario'];

        if (array_key_exists("nom_usuario", $dbArray))
            $this->nomUsuario = $dbArray['nom_usuario'];

        if (array_key_exists("email_usuario", $dbArray))
            $this->emailUsuario = $dbArray['email_usuario'];

        $this->senhaUsuario = "";
    }
}