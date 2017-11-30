<?php

class PaginaImagemRepository extends BaseRepository
{

    function GetThis($idPaginaImagem)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
                id_pagina_imagem, id_pagina_dado, valor_pagina_imagem
            FROM 
                tb_pagina_imagem
            WHERE 
                id_pagina_imagem = :id_pagina_imagem';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':id_pagina_imagem', $idPaginaImagem);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    function Get($idPaginaDado)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
                id_pagina_dado, tipo, valor_pagina_imagem
            FROM 
                tb_pagina_imagem
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

        $sql = 'INSERT INTO tb_pagina_imagem (id_pagina_dado, valor_pagina_imagem) VALUES (:idPaginaDado, :valorPaginaImagem)';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':idPaginaDado', $paginaDado->idPaginaDado);
        $stm->bindParam(':valorPaginaImagem', $paginaDado->valorPaginaDado);
        $stm->execute();

        return $stm->rowCount() > 0;
    }

    function Update(PaginaDado &$paginaDado)
    {
        $conn = $this->db->getConnection();

        $sql = 'UPDATE 
                    tb_pagina_imagem
                SET 
                    valor_pagina_imagem_64 = :valorPaginaImagem
                WHERE 
                    id_pagina_dado = :idPaginaImagem';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':valorPaginaImagem', $paginaDado->valorPaginaDado);
        $stm->bindParam(':idPaginaImagem', $paginaDado->idPaginaDado);
        $stm->execute();

        return $stm->rowCount() > 0;
    }

	function InsertOrUpdate(PaginaDado &$paginaDado) {
		$conn = $this->db->getConnection();

		$sql = 'SELECT * FROM tb_pagina_imagem WHERE id_pagina_dado = :idPaginaDado ';

		$stm = $conn->prepare($sql);
		$stm->bindParam(':idPaginaDado', $paginaDado->idPaginaDado);
		$stm->execute();

		if ($stm->rowCount() > 0) {
			$this->Update($paginaDado);
		} else {
			$this->Insert($paginaDado);
		}
	}
    
    function Delete($idPaginaImagem)
    {
        $conn = $this->db->getConnection();

        $sql = 'DELETE FROM tb_pagina_imagem
                WHERE id_pagina_imagem = :idPaginaImagem';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':idPaginaImagem', $idPaginaImagem);
        $stm->execute();

        return $stm->rowCount() > 0;
    }
}