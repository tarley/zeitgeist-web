<?php

class PaginaRepository extends BaseRepository
{

    function GetThis($idPagina)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
                id_pagina, 
                id_jornal, 
                id_template, 
                num_pagina, 
                nom_pagina
            FROM 
                tb_pagina
            WHERE 
                id_pagina = :id_pagina';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':id_pagina', $idPagina);
        $stm->execute();
        $pagina = $stm->fetch(PDO::FETCH_ASSOC);

        $paginaDadoRepository = new PaginaDadoRepository();

        //$pagina["pagina_dado"] = $paginaDadoRepository->GetList($pagina["id_pagina"], $conn);

        return $pagina;
    }

    function GetList($idJornal)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
                p.id_pagina, p.id_jornal, p.id_template, p.num_pagina, p.nom_pagina,
                t.desc_template, (SELECT COUNT(*) FROM tb_pagina p1 WHERE p1.id_jornal = p.id_jornal) as qtd_paginas_jornal
            FROM 
                tb_pagina p
          INNER JOIN tb_template t ON t.id_template = p.id_template  
            WHERE
                 p.id_jornal = :id_jornal
            ORDER BY p.num_pagina';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':id_jornal', $idJornal);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function Insert(Pagina &$pagina)
    {
        $conn = $this->db->getConnection();

        $sql = 'INSERT INTO tb_pagina (id_jornal, id_template, num_pagina, nom_pagina) VALUES (:id_jornal, :id_template, :num_pagina, :nom_pagina)';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':id_jornal', $pagina->idJornal);
        $stm->bindParam(':id_template', $pagina->idTemplate);
        $stm->bindParam(':num_pagina', $pagina->numPagina);
        $stm->bindParam(':nom_pagina', $pagina->nomPagina);
        $stm->execute();

        $pagina->idPagina = $conn->lastInsertId();

        return $stm->rowCount() > 0;
    }

    function Update(Pagina &$pagina)
    {
        $conn = $this->db->getConnection();

        $sql = 'UPDATE 
                    tb_pagina 
                SET 
                    id_jornal = :idJornal, 
                    id_template = :idTemplate, 
                    num_pagina = :numPagina, 
                    nom_pagina = :nomPagina
                WHERE 
                    id_pagina = :idPagina';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':idJornal', $pagina->idJornal);
        $stm->bindParam(':idTemplate', $pagina->idTemplate);
        $stm->bindParam(':numPagina', $pagina->numPagina);
        $stm->bindParam(':nomPagina', $pagina->nomPagina);
        $stm->bindParam(':idPagina', $pagina->idPagina);
        $stm->execute();

        return $stm->rowCount() > 0;
    }
    
    function Delete($idPagina)
    {
        $conn = $this->db->getConnection();

        $sql = 'DELETE FROM tb_pagina 
                WHERE id_pagina = :idPagina';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':idPagina', $idPagina);
        $stm->execute();

        return $stm->rowCount() > 0;
    }
}