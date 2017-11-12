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
  
    function GetThisUltimaEdicao()
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT IFNULL(MAX(num_edicao_jornal), 0) + 1 as num_edicao_jornal
            FROM 
                tb_jornal';

        $stm = $conn->prepare($sql);
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

    function GetLastPublish()
    {
        $conn = $this->db->getConnection();

        $sql = '
            SELECT j.id_jornal,
                   j.num_edicao_jornal,
                   j.nom_titulo_jornal,
                   j.dta_publicacao_jornal,
                   j.dta_ultima_atualizacao_jornal,
                   u.nom_usuario,
                   u.email_usuario
              FROM tb_jornal j 
        INNER JOIN tb_usuario u ON u.id_usuario = j.id_usuario
             WHERE j.dta_publicacao_jornal = (SELECT max(j1.dta_publicacao_jornal)
                                                FROM tb_jornal j1
                                               WHERE j1.id_situacao = 2)';


        $stm = $conn->prepare($sql);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }
 
 /*    function Update(Jornal &$jornal)*/
    function Update(Jornal &$jornal)
    {
        $conn = $this->db->getConnection();

        $sql = 'UPDATE tb_jornal SET 
            id_situacao = :id_situacao, 
            num_edicao_jornal = :num_edicao_jornal, 
            nom_titulo_jornal = :nom_titulo_jornal, 
            dta_publicacao_jornal = :dta_publicacao_jornal,
            dta_ultima_atualizacao_jornal = NOW()
        WHERE id_jornal = :id_jornal';

        $dataPublicacao = DateTime::createFromFormat("d/m/Y", $jornal->dtaPublicacaoJornal);
        $dataPublicacao = date_format($dataPublicacao, "Y-m-d");
        
        $stm = $conn->prepare($sql);
        $stm->bindParam(':id_situacao', $jornal->idSituacao);
        $stm->bindParam(':num_edicao_jornal', $jornal->numEdicaoJornal);
        $stm->bindParam(':nom_titulo_jornal', $jornal->nomTituloJornal);
        $stm->bindParam(':dta_publicacao_jornal', $dataPublicacao);
        $stm->bindParam(':id_jornal', $jornal->idJornal);
        $stm->execute();

        return $stm->rowCount() > 0;
    }

    function SubirPagina($idPagina)
    {
        $conn = $this->db->getConnection();
        
        $sql = 'SELECT * FROM tb_pagina WHERE id_pagina = :idPagina';
        $stm = $conn->prepare($sql);
        $stm->bindParam(':idPagina', $idPagina);
        $stm->execute();
        $resultPagina = $stm->fetch(PDO::FETCH_ASSOC);
        
        $numPaginaOriginal = $resultPagina['num_pagina'];
        $numPagina = $numPaginaOriginal - 1;
        $idJornal = $resultPagina['id_jornal'];
        
        $sql1 = 'SELECT * FROM tb_pagina WHERE num_pagina = :numPagina AND id_jornal = :idJornal';
        $stm1 = $conn->prepare($sql1);
        $stm1->bindParam(':numPagina', $numPagina);
        $stm1->bindParam(':idJornal', $idJornal);
        $stm1->execute();
        $resultPaginaAnterior = $stm1->fetch(PDO::FETCH_ASSOC);
        
        $idPaginaAnterior = $resultPaginaAnterior['id_pagina'];
        
        //Atualiza o número da página anterior para mil para não ocorrer conflito de integridade na coluna no banco
        $sqlAux = 'UPDATE tb_pagina SET 
        num_pagina = 1000
        WHERE id_pagina = :idPagina';
        $stmAux = $conn->prepare($sqlAux);
        $stmAux->bindParam(':idPagina', $idPaginaAnterior);
        $stmAux->execute();
        
        //Altera a página atual para o lugar da anterior
        $sql3 = 'UPDATE tb_pagina SET 
        num_pagina = num_pagina - 1
        WHERE id_pagina = :idPagina';
        $stm3 = $conn->prepare($sql3);
        $stm3->bindParam(':idPagina', $idPagina);
        $stm3->execute();
        
        //Altera a página anterior para o lugar da pagina atual
        $sql2 = 'UPDATE tb_pagina SET 
        num_pagina = :numPagina
        WHERE id_pagina = :idPagina';
        $stm2 = $conn->prepare($sql2);
        $stm2->bindParam(':idPagina', $idPaginaAnterior);
        $stm2->bindParam(':numPagina', $numPaginaOriginal);
        $stm2->execute();
        
        //Retorna a lista de páginas atualizadas 
        $sql4 = 'SELECT 
                p.id_pagina, p.id_jornal, p.id_template, p.num_pagina, p.nom_pagina,
                t.desc_template, (SELECT COUNT(*) FROM tb_pagina p1 WHERE p1.id_jornal = p.id_jornal) as qtd_paginas_jornal
            FROM 
                tb_pagina p
          INNER JOIN tb_template t ON t.id_template = p.id_template  
            WHERE
                 p.id_jornal = :id_jornal
            ORDER BY p.num_pagina';

        $stm4 = $conn->prepare($sql4);
        $stm4->bindParam(':id_jornal', $idJornal);
        $stm4->execute();
        $result = $stm4->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    
    function DescerPagina($idPagina)
    {
        $conn = $this->db->getConnection();
        
        $sql = 'SELECT * FROM tb_pagina WHERE id_pagina = :idPagina';
        $stm = $conn->prepare($sql);
        $stm->bindParam(':idPagina', $idPagina);
        $stm->execute();
        $resultPagina = $stm->fetch(PDO::FETCH_ASSOC);
        
        $numPaginaOriginal = $resultPagina['num_pagina'];
        $numPagina = $numPaginaOriginal + 1;
        $idJornal = $resultPagina['id_jornal'];
        
        $sql1 = 'SELECT * FROM tb_pagina WHERE num_pagina = :numPagina AND id_jornal = :idJornal';
        $stm1 = $conn->prepare($sql1);
        $stm1->bindParam(':numPagina', $numPagina);
        $stm1->bindParam(':idJornal', $idJornal);
        $stm1->execute();
        $resultProximaPagina = $stm1->fetch(PDO::FETCH_ASSOC);
        
        $idProximaPagina = $resultProximaPagina['id_pagina'];
        
        //Atualiza o número da próxima página para mil para não ocorrer conflito de integridade na coluna no banco
        $sqlAux = 'UPDATE tb_pagina SET 
        num_pagina = 1000
        WHERE id_pagina = :idPagina';
        $stmAux = $conn->prepare($sqlAux);
        $stmAux->bindParam(':idPagina', $idProximaPagina);
        $stmAux->execute();
        
        //Altera a página atual para o lugar da anterior
        $sql3 = 'UPDATE tb_pagina SET 
        num_pagina = num_pagina + 1
        WHERE id_pagina = :idPagina';
        $stm3 = $conn->prepare($sql3);
        $stm3->bindParam(':idPagina', $idPagina);
        $stm3->execute();
        
        //Altera a próxima página para o lugar da pagina atual
        $sql2 = 'UPDATE tb_pagina SET 
        num_pagina = :numPagina
        WHERE id_pagina = :idPagina';
        $stm2 = $conn->prepare($sql2);
        $stm2->bindParam(':idPagina', $idProximaPagina);
        $stm2->bindParam(':numPagina', $numPaginaOriginal);
        $stm2->execute();
        
        //Retorna a lista de páginas atualizadas 
        $sql4 = 'SELECT 
                p.id_pagina, p.id_jornal, p.id_template, p.num_pagina, p.nom_pagina,
                t.desc_template, (SELECT COUNT(*) FROM tb_pagina p1 WHERE p1.id_jornal = p.id_jornal) as qtd_paginas_jornal
            FROM 
                tb_pagina p
          INNER JOIN tb_template t ON t.id_template = p.id_template  
            WHERE
                 p.id_jornal = :id_jornal
            ORDER BY p.num_pagina';

        $stm4 = $conn->prepare($sql4);
        $stm4->bindParam(':id_jornal', $idJornal);
        $stm4->execute();
        $result = $stm4->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    
    function PublicarJornal($idJornal)
    {
     $conn = $this->db->getConnection();

        $sql = 'UPDATE tb_jornal SET 
            id_situacao = 2
        WHERE id_jornal = :id_jornal';
        
        $stm = $conn->prepare($sql);
        $stm->bindParam(':id_jornal', $idJornal);
        $stm->execute();

        return $stm->rowCount() > 0;   
    }
}