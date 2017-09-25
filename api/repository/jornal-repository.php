<?php

class JornalRepository extends BaseRepository
{

   function GetThis($id_jornal)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
               id_jornal,S.id_situacao,S.desc_situacao,num_edicao_jornal,nom_titulo_jornal,dta_publicacao_jornal,dta_ultima_atualizacao_jornal,
               (SELECT valor_pagina_imagem FROM tb_pagina_imagem pi INNER JOIN tb_pagina p WHERE p.id_jornal = J.id_jornal AND num_pagina = 1) as valor_pagina_imagem
            FROM 
                tb_jornal J INNER JOIN tb_situacao S ON(J.id_situacao=S.id_situacao)
            WHERE 
                id_jornal = :id_jornal';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':id_jornal', $id_jornal);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
  
  

    function GetList()
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
               id_jornal,S.id_situacao,S.desc_situacao,num_edicao_jornal,nom_titulo_jornal,dta_publicacao_jornal,dta_ultima_atualizacao_jornal
            FROM 
                tb_jornal J INNER JOIN tb_situacao S ON(J.id_situacao=S.id_situacao)';


      $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

    function Insert(Jornal &$jornal)
    {
      
          $conn = $this->db->getConnection();

        $sql = 'INSERT INTO tb_jornal (idUsuario,idSituacao,nomTituloJornal,numEdicaoJornal,dtaPublicacaoJornal,dtaUltimaAtualizacaoJornal) 
        VALUES (:nome, :endereco, :telefone, :email, :login, SHA1(:senha))';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':id_jornal', $jornal->idJornal);
        $stm->bindParam(':id_usuario', $jornal->idUsuario);
        $stm->bindParam(':id_situacao', $jornal->idSituacao);
        $stm->bindParam(':num_edicao_jornal', $jornal->nomTituloJornal);
        $stm->bindParam(':num_titulo_jornal', $jornal->numEdicaoJornal);
        $stm->bindParam(':dta_publicacao_jornal', $jornal->dtaPublicacaoJornal);
        $stm->bindParam(':dta_ultima_atualizacao_jornal', $jornal->dtaUltimaAtualizacaoJornal);
  
        $stm->execute();

        $jornal->idJornal = $conn->lastInsertId();

        return $stm->rowCount() > 0;
    }


 






 /*    function Update(Jornal &$jornal)
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
    }*/

}