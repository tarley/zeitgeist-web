<?php

class PaginaStringRepository extends BaseRepository
{

    function GetThis($idPaginaString)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
                id_pagina_string, id_pagina_dado, valor_pagina_string
            FROM 
                tb_pagina_string
            WHERE 
                id_pagina_String = :id_pagina_String';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':id_pagina_string', $idPaginaString);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    function Get($idPaginaDado)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
                id_pagina_dado, valor_pagina_string
            FROM 
                tb_pagina_string
            WHERE 
                id_pagina_dado = :id_pagina_dado';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':id_pagina_dado', $idPaginaDado);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    function Insert(PaginaString &$paginaString)
    {
        $conn = $this->db->getConnection();

        $sql = 'INSERT INTO tb_pagina_string (id_pagina_dado, valor_pagina_string) VALUES (:idPaginaDado, :valorPaginaString)';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':idPaginaDado', $pagina->idPaginaDado);
        $stm->bindParam(':valorPaginaString', $pagina->valorPaginaString);
        $stm->execute();

        $pagina->idPaginaString = $conn->lastInsertId();

        return $stm->rowCount() > 0;
    }

    function Update(PaginaString &$paginaString)
    {
        $conn = $this->db->getConnection();

        $sql = 'UPDATE 
                    tb_pagina_string
                SET 
                    valor_pagina_string = :valorPaginaString
                WHERE 
                    id_pagina_string = :idPaginaString';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':valorPaginaString', $paginaString->valorPaginaString);
        $stm->bindParam(':idPaginaString', $paginaString->idPaginaString);
        $stm->execute();

        return $stm->rowCount() > 0;
    }
    
    function Delete($idPaginaString)
    {
        $conn = $this->db->getConnection();

        $sql = 'DELETE FROM tb_pagina_string
                WHERE id_pagina_string = :idPaginaString';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':idPaginaString', $idPaginaString);
        $stm->execute();

        return $stm->rowCount() > 0;
    }
}