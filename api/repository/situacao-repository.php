<?php

class SituacaoRepository extends BaseRepository
{

    function GetThis($codUsuario)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
                cod_usuario, u.nome, endereco, telefone, email, login 
            FROM 
                tb_usuario u
            WHERE 
                cod_usuario = :cod_usuario';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':cod_usuario', $codUsuario);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    function GetList()
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
                cod_usuario, u.nome, telefone, email, login
            FROM 
                tb_usuario u';

        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function Insert(Usuario &$usuario)
    {
        if (!$this->IsAvailableUser($usuario->login))
            throw new Warning("Login já cadastrado");

        $conn = $this->db->getConnection();

        $sql = 'INSERT INTO tb_usuario (nome, endereco, telefone, email, login, senha) VALUES (:nome, :endereco, :telefone, :email, :login, SHA1(:senha))';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':nome', $usuario->nome);
        $stm->bindParam(':endereco', $usuario->endereco);
        $stm->bindParam(':telefone', $usuario->telefone);
        $stm->bindParam(':email', $usuario->email);
        $stm->bindParam(':login', $usuario->login);
        $stm->bindParam(':senha', $usuario->senha);
        $stm->execute();

        $usuario->codUsuario = $conn->lastInsertId();

        return $stm->rowCount() > 0;
    }

    function Update(Usuario &$usuario)
    {
        if (!$this->IsAvailableUser($usuario->login, $usuario->codUsuario))
            throw new Warning("Login já cadastrado");

        $conn = $this->db->getConnection();

        $sql = 'UPDATE tb_usuario SET 
            nome = :nome, 
            endereco = :endereco, 
            telefone = :telefone, 
            email = :email,
            login = :login
        WHERE cod_usuario = :codUsuario';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':codUsuario', $usuario->codUsuario);
        $stm->bindParam(':nome', $usuario->nome);
        $stm->bindParam(':endereco', $usuario->endereco);
        $stm->bindParam(':telefone', $usuario->telefone);
        $stm->bindParam(':email', $usuario->email);
        $stm->bindParam(':login', $usuario->login);
        $stm->execute();

        return $stm->rowCount() > 0;
    }

    function Login(Usuario &$usuario)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT cod_usuario, nome FROM tb_usuario WHERE login = :login && senha = SHA1(:senha)';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':login', $usuario->login);
        $stm->bindParam(':senha', $usuario->senha);
        $stm->execute();

        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (!$result['cod_usuario']) {
            throw new Warning("Usuário ou senha inválidos");
        }

        $usuario->FillByDB($result);
    }

    private function IsAvailableUser($login, $codUsuario = null)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT cod_usuario FROM tb_usuario WHERE login = :login';

        if ($codUsuario)
            $sql .= ' AND cod_usuario <> :codUsuario';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':login', $login);

        if ($codUsuario)
            $stm->bindParam(':codUsuario', $codUsuario);

        $stm->execute();

        return $stm->rowCount() == 0;
    }
}