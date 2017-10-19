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
  
    function GetThisMobile()
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
               id_jornal,num_edicao_jornal,nom_titulo_jornal,dta_publicacao_jornal,dta_ultima_atualizacao_jornal
            FROM 
                tb_jornal J
            WHERE 
                id_jornal = (SELECT MAX(id_jornal) FROM tb_jornal)';

        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    function GetList($id_situacao)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
               id_jornal,S.id_situacao,S.desc_situacao,num_edicao_jornal,nom_titulo_jornal, dta_publicacao_jornal, date_format(dta_publicacao_jornal, "%m/%Y") AS dta_publicacao_jornal_reduzida, "%d/%m/%Y",dta_ultima_atualizacao_jornal,
               (SELECT pi.valor_pagina_imagem
            		FROM tb_pagina_imagem pi 
            		INNER JOIN tb_pagina_dado pd ON (pi.id_pagina_dado = pd.id_pagina_dado)
            		INNER JOIN tb_pagina p ON (pd.id_pagina = p.id_pagina)
            		INNER JOIN tb_jornal jn ON (p.id_jornal = jn.id_jornal)
            		WHERE 
            		    p.num_pagina = 1 AND 
            		    jn.id_jornal = J.id_jornal
            	) as valor_pagina_imagem
            FROM 
                tb_jornal J INNER JOIN tb_situacao S ON(J.id_situacao=S.id_situacao)
            WHERE
                :id_situacao IS NULL OR J.id_situacao = :id_situacao
            ORDER BY 
                num_edicao_jornal DESC';

      $stm = $conn->prepare($sql);
      $stm->bindParam(':id_situacao', $id_situacao);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

    function Insert(Jornal &$jornal)
    {
      
        $conn = $this->db->getConnection();

        $sql = 'INSERT INTO tb_jornal (id_usuario, id_situacao, num_edicao_jornal, nom_titulo_jornal, dta_publicacao_jornal, dta_ultima_atualizacao_jornal) 
        VALUES (:id_usuario, :id_situacao, :num_edicao_jornal, :nom_titulo_jornal, :dta_publicacao_jornal, NOW())';

        $dataPublicacao = DateTime::createFromFormat("d/m/Y", $jornal->dtaPublicacaoJornal);
        $dataPublicacao = date_format($dataPublicacao, "Y-m-d");
        
        $stm = $conn->prepare($sql);
        $stm->bindParam(':id_usuario', $jornal->idUsuario);
        $stm->bindParam(':id_situacao', $jornal->idSituacao);
        $stm->bindParam(':num_edicao_jornal', $jornal->numEdicaoJornal);
        $stm->bindParam(':nom_titulo_jornal', $jornal->nomTituloJornal);
        $stm->bindParam(':dta_publicacao_jornal', $dataPublicacao);
  
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