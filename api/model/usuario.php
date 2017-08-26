<?php

class Usuario
{
    var $codUsuario;
    var $nome;
    var $endereco;
    var $telefone;
    var $email;
    var $login;
    var $senha;
    var $codPerfil;
    var $nomePerfil;

    function FillByObject($obj)
    {
        if (property_exists($obj, 'codUsuario'))
            $this->codUsuario = $obj->codUsuario;

        if (property_exists($obj, 'nome'))
            $this->nome = $obj->nome;

        if (property_exists($obj, 'endereco'))
            $this->endereco = $obj->endereco;

        if (property_exists($obj, 'telefone'))
            $this->telefone = $obj->telefone;

        if (property_exists($obj, 'email'))
            $this->email = $obj->email;

        if (property_exists($obj, 'login'))
            $this->login = $obj->login;

        if (property_exists($obj, 'senha'))
            $this->senha = $obj->senha;

        if (property_exists($obj, 'codPerfil'))
            $this->codPerfil = $obj->codPerfil;

        if (property_exists($obj, 'nomePerfil'))
            $this->nomePerfil = $obj->nomePerfil;
    }

    function FillByDB($dbArray)
    {
        if (array_key_exists("cod_usuario", $dbArray))
            $this->codUsuario = $dbArray['cod_usuario'];

        if (array_key_exists("nome", $dbArray))
            $this->nome = $dbArray['nome'];

        if (array_key_exists("endereco", $dbArray))
            $this->endereco = $dbArray['endereco'];

        if (array_key_exists("telefone", $dbArray))
            $this->telefone = $dbArray['telefone'];

        if (array_key_exists("email", $dbArray))
            $this->email = $dbArray['email'];

        if (array_key_exists("login", $dbArray))
            $this->login = $dbArray['login'];

        if (array_key_exists("cod_perfil", $dbArray))
            $this->codPerfil = $dbArray['cod_perfil'];

        if (array_key_exists("nome_perfil", $dbArray))
            $this->nomePerfil = $dbArray['nome_perfil'];

    }
}