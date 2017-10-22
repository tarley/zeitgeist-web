<?php

class PaginaTextoRepository extends BaseRepository
{

    function GetThis($idPaginaTexto)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
                id_pagina_dado, valor_pagina_texto
            FROM 
                tb_pagina_texto
            WHERE 
                id_pagina_texto = :id_pagina_texto';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':id_pagina_texto', $idPaginaTexto);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    function Get($idPaginaDado)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
                id_pagina_dado, valor_pagina_texto
            FROM 
                tb_pagina_texto
            WHERE 
                id_pagina_dado = :id_pagina_dado';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':id_pagina_dado', $idPaginaDado);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    function Insert(PaginaTexto &$paginaTexto)
    {
        $conn = $this->db->getConnection();

        $sql = 'INSERT INTO tb_pagina_texto (id_pagina_dado, valor_pagina_texto) VALUES (:idPaginaDado, :valorPaginaTexto)';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':idPaginaDado', $pagina->idPaginaDado);
        $stm->bindParam(':valorPaginaTexto', $pagina->valorPaginaTexto);
        $stm->execute();

        $pagina->idPaginaTexto = $conn->lastInsertId();

        return $stm->rowCount() > 0;
    }

    function Update(PaginaTexto &$paginaTexto)
    {
        $conn = $this->db->getConnection();

        $sql = 'UPDATE 
                    tb_pagina_texto
                SET 
                    valor_pagina_texto = :valorPaginaTexto
                WHERE 
                    id_pagina_texto = :idPaginaTexto';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':valorPaginaTexto', $paginaTexto->valorPaginaTexto);
        $stm->bindParam(':idPaginaTexto', $paginaTexto->idPaginaTexto);
        $stm->execute();

        return $stm->rowCount() > 0;
    }
    
    function Delete($idPaginaTexto)
    {
        $conn = $this->db->getConnection();

        $sql = 'DELETE FROM tb_pagina_texto
                WHERE id_pagina_texto = :idPaginaTexto';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':idPaginaTexto', $idPaginaTexto);
        $stm->execute();

        return $stm->rowCount() > 0;
    }
}