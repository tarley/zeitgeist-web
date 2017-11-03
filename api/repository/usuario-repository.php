<?php

class UsuarioRepository extends BaseRepository
{

    function GetThis($idUsuario)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
                id_usuario, nom_usuario, email_usuario 
            FROM 
                tb_usuario 
            WHERE 
                id_usuario = :id_usuario';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':id_usuario', $idUsuario);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    function GetList()
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
                id_usuario, nom_usuario, email_usuario 
            FROM 
                tb_usuario';

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

        $sql = 'INSERT INTO tb_usuario (nom_usuario, email_usuario, senha_usuario) VALUES (:nomUsuario, :emailUsuario, SHA1(:senhaUsuario))';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':nomUsuario', $usuario->nomUsuario);
        $stm->bindParam(':emailUsuario', $usuario->emailUsuario);
        $stm->bindParam(':senhaUsuario', $usuario->senhaUsuario);
        $stm->execute();

        $usuario->idUsuario = $conn->lastInsertId();

        return $stm->rowCount() > 0;
    }

    function Update(Usuario &$usuario)
    {
        if (!$this->IsAvailableUser($usuario->login, $usuario->codUsuario))
            throw new Warning("Login já cadastrado");

        $conn = $this->db->getConnection();

        $sql = 'UPDATE tb_usuario SET 
            nom_usuario = :nomUsuario, 
            email_usuario = :emailUsuario, 
            senha_usuario = SHA1(:senhaUsuario)
        WHERE id_usuario = :idUsuario';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':nomUsuario', $usuario->nomUsuario);
        $stm->bindParam(':emailUsuario', $usuario->emailUsuario);
        $stm->bindParam(':senhaUsuario', $usuario->senhaUsuario);
        $stm->bindParam(':idUsuario', $usuario->idUsuario);
        $stm->execute();

        return $stm->rowCount() > 0;
    }

    function Login(Usuario &$usuario)
    {
        $conn = $this->db->getConnection();

        Log::Debug(print_r($usuario, true));

        $sql = 'SELECT u.id_usuario,  
                       u.nom_usuario,
                       u.email_usuario,
                       u.senha_usuario,
                       u.id_perfil_usuario,
                       p.nome_perfil
                  FROM tb_usuario u
                INNER JOIN tb_perfil_usuario p ON p.id_perfil_usuario = u.id_perfil_usuario
                 WHERE email_usuario = :login
               ';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':login', $usuario->emailUsuario);
        $stm->execute();

        $result = $stm->fetch(PDO::FETCH_ASSOC);
        Log::Debug(print_r($result, true));
        
        if (empty($result)) {
            throw new Warning("Usuário não encontrado.");
        }
        
        $senha = sha1($usuario->senhaUsuario);
        
        if($senha != $result['senha_usuario']) {
            throw new Warning("Senha inválida.");
        }
        
        unset($result['senha_usuario']);

        $usuario->FillByDB($result);
    }

    private function IsAvailableUser($emailUsuario, $idUsuario = null)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT id_usuario FROM tb_usuario WHERE email_usuario = :emailUsuario';

        if ($idUsuario)
            $sql .= ' AND id_usuario <> :idUsuario';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':emailUsuario', $emailUsuario);

        if ($codUsuario)
            $stm->bindParam(':idUsuario', $idUsuario);

        $stm->execute();

        return $stm->rowCount() == 0;
    }
}