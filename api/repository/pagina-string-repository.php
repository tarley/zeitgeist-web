<?php

class PaginaStringRepository extends BaseRepository
{

    function GetThis($idPaginaString)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
                id_pagina_dado, valor_pagina_string
            FROM 
                tb_pagina_string
            WHERE 
                id_pagina_dado = :idPaginaDado';

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

    function Insert(PaginaDado &$paginaDado)
    {
        $conn = $this->db->getConnection();

        $sql = 'INSERT INTO tb_pagina_string (id_pagina_dado, valor_pagina_string) VALUES (:idPaginaDado, :valorPaginaString)';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':idPaginaDado', $paginaDado->idPaginaDado);
        $stm->bindParam(':valorPaginaString', $paginaDado->valorPaginaDado);
        $stm->execute();

        return $stm->rowCount() > 0;
    }

    function Update(PaginaDado &$paginaDado)
    {
        $conn = $this->db->getConnection();

        $sql = 'UPDATE 
                    tb_pagina_string
                SET 
                    valor_pagina_string = :valorPaginaString
                WHERE 
                    id_pagina_dado = :idPaginaDado';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':valorPaginaString', $paginaDado->valorPaginaDado);
        $stm->bindParam(':idPaginaDado', $paginaDado->idPaginaDado);
        $stm->execute();

        return $stm->rowCount() > 0;
    }

    function InsertOrUpdate(PaginaDado &$paginaDado) {
		$conn = $this->db->getConnection();

		$sql = 'SELECT * FROM tb_pagina_string WHERE id_pagina_dado = :idPaginaDado ';

		$stm = $conn->prepare($sql);
		$stm->bindParam(':idPaginaDado', $paginaDado->idPaginaDado);
		$stm->execute();

		if ($stm->rowCount() > 0) {
			$this->Update($paginaDado);
		} else {
			$this->Insert($paginaDado);
		}
	}
    
    function Delete($idPaginaString)
    {
        $conn = $this->db->getConnection();

        $sql = 'DELETE FROM tb_pagina_string WHERE id_pagina_dado = :idPaginaDado';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':idPaginaDado', $idPaginaString);
        $stm->execute();

        return $stm->rowCount() > 0;
    }
}