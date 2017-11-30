<?php

class PaginaDadoRepository extends BaseRepository
{

    function GetThis($idPaginaDado)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
                id_pagina_dado, id_pagina, id_template_dado
            FROM 
                tb_pagina_dado
            WHERE 
                id_pagina_dado = :id_pagina_dado';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':id_pagina_dado', $idPaginaDado);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    function GetList($idPagina)
    {
        $conn = $this->db->getConnection();

        $sql = ' SELECT pd.id_pagina_dado, 
                        pd.id_pagina, 
                        pd.id_template_dado,
                        td.id_tipo_template_dado,
                        td.chave_template_dado,
                        td.desc_template_dado,
						CASE
							WHEN td.id_tipo_template_dado = 1 THEN ps.valor_pagina_string
							WHEN td.id_tipo_template_dado = 2 THEN pt.valor_pagina_texto
							WHEN td.id_tipo_template_dado = 3 THEN pi.valor_pagina_imagem_64
						END AS valor_pagina_dado,
						pi.tipo
					FROM tb_pagina_dado pd
						INNER JOIN tb_template_dado td ON td.id_template_dado = pd.id_template_dado
						LEFT JOIN tb_pagina_imagem pi ON (pd.id_pagina_dado = pi.id_pagina_dado)
						LEFT JOIN tb_pagina_string ps ON (pd.id_pagina_dado = ps.id_pagina_dado)
						LEFT JOIN tb_pagina_texto pt ON (pd.id_pagina_dado = pt.id_pagina_dado)             
					WHERE pd.id_pagina = :id_pagina';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':id_pagina', $idPagina);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    
    function GetListMobile($idPagina)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
                id_pagina_dado, id_pagina, pd.id_template_dado, td.chave_template_dado,
                CASE
                    WHEN td.id_tipo_template_dado = 1 THEN ps.valor_pagina_string
                    WHEN td.id_tipo_template_dado = 2 THEN pi.valor_pagina_imagem
                    WHEN td.id_tipo_template_dado = 3 THEN pt. valor_pagina_texto
                END AS ValorMetadado
            FROM 
                tb_pagina_dado pd
                INNER JOIN tb_template_dado td ON (pd.id_template_dado = td.id_template_dado)
                LEFT JOIN tb_pagina_string ps ON (td.id_pagina_dado = ps.id_pagina_dado)
                LEFT JOIN tb_pagina_imagem pi ON (td.id_pagina_dado = pi.id_pagina_dado)
                LEFT JOIN tb_pagina_string ps ON (td.id_pagina_dado = ps.id_pagina_dado)
                LEFT JOIN tb_pagina_texto pt ON (td.id_pagina_dado = pt.id_pagina_dado)
            WHERE 
                id_pagina = :id_pagina';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':id_pagina', $idPagina);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function Insert(PaginaDado &$paginaDado)
    {
        $conn = $this->db->getConnection();

        $sql = 'INSERT INTO tb_pagina_dado (id_pagina, id_template_dado) VALUES (:id_pagina, :id_template_dado)';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':id_pagina', $paginaDado->idPagina);
        $stm->bindParam(':id_template_dado', $paginaDado->idTemplateDado);
        $stm->execute();

        $paginaDado->idPaginaDado = $conn->lastInsertId();

		if ($paginaDado->idTipoTemplateDado == 1) {
			$rep = new PaginaStringRepository();
			$rep->InsertOrUpdate($paginaDado);
		} else if ($paginaDado->idTipoTemplateDado == 2) {
			$rep = new PaginaTextoRepository();
			$rep->InsertOrUpdate($paginaDado);
		} else if ($paginaDado->idTipoTemplateDado == 3) {
			$rep = new PaginaImagemRepository();
			$rep->InsertOrUpdate($paginaDado);
		}

        return $stm->rowCount() > 0;
    }

    function Update(PaginaDado &$paginaDado)
    {
        $conn = $this->db->getConnection();

        $sql = 'UPDATE 
                    tb_pagina_dado
                SET 
                    id_template_dado = :idTemplateDado
                WHERE 
                    id_pagina_dado = :idPaginaDado';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':idTemplateDado', $paginaDado->idTemplateDado);
        $stm->bindParam(':idPaginaDado', $paginaDado->idPaginaDado);
        $stm->execute();

		if ($paginaDado->idTipoTemplateDado == 1) {
			$rep = new PaginaStringRepository();
			$rep->InsertOrUpdate($paginaDado);
		} else if ($paginaDado->idTipoTemplateDado == 2) {
			$rep = new PaginaTextoRepository();
			$rep->InsertOrUpdate($paginaDado);
		} else if ($paginaDado->idTipoTemplateDado == 3) {
			$rep = new PaginaImagemRepository();
			$rep->InsertOrUpdate($paginaDado);
		}

		return $stm->rowCount() > 0;
    }
    
    function Delete($idPaginaDado)
    {
        $conn = $this->db->getConnection();

        $sql = 'DELETE FROM tb_pagina_dado 
                WHERE id_pagina_dado = :idPaginaDado';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':idPaginaDado', $idPaginaDado);
        $stm->execute();

        return $stm->rowCount() > 0;
    }

    function DeleteAllByPage($idPagina) {
		$conn = $this->db->getConnection();

		$sql = 'DELETE FROM tb_pagina_string WHERE id_pagina_dado IN (SELECT id_pagina_dado FROM tb_pagina_dado WHERE id_pagina = :idPagina)';
		$stm = $conn->prepare($sql);
		$stm->bindParam(':idPagina', $idPagina);
		$stm->execute();

		$sql = 'DELETE FROM tb_pagina_texto WHERE id_pagina_dado IN (SELECT id_pagina_dado FROM tb_pagina_dado WHERE id_pagina = :idPagina)';
		$stm = $conn->prepare($sql);
		$stm->bindParam(':idPagina', $idPagina);
		$stm->execute();

		$sql = 'DELETE FROM tb_pagina_imagem WHERE id_pagina_dado IN (SELECT id_pagina_dado FROM tb_pagina_dado WHERE id_pagina = :idPagina)';
		$stm = $conn->prepare($sql);
		$stm->bindParam(':idPagina', $idPagina);
		$stm->execute();

		$sql = 'DELETE FROM tb_pagina_dado WHERE id_pagina = :idPagina';

		$stm = $conn->prepare($sql);
		$stm->bindParam(':idPagina', $idPagina);
		$stm->execute();

		return $stm->rowCount() > 0;
	}
}