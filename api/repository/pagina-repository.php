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

        $pagina["pagina_dado"] = $paginaDadoRepository->GetList($pagina["id_pagina"], $conn);

        return $pagina;
    }

    function GetList($idJornal)
    {
        $conn = $this->db->getConnection();

		$sql = 'SELECT 
                	p.id_pagina, 
                	p.id_jornal, 
                	p.id_template, 
                	p.num_pagina, 
                	p.nom_pagina,
               	 	t.desc_template, 
               	 	(SELECT COUNT(*) FROM tb_pagina p1 WHERE p1.id_jornal = p.id_jornal) as qtd_paginas_jornal
            	FROM 
                	tb_pagina p
          			INNER JOIN tb_template t ON t.id_template = p.id_template  
            	WHERE
                 	p.id_jornal = :idJornal
            	ORDER BY p.num_pagina';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':idJornal', $idJornal);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function Insert(Pagina &$pagina)
    {
        $conn = $this->db->getConnection();

        $sql = 'INSERT INTO tb_pagina (id_jornal, id_template, num_pagina, nom_pagina) VALUES (:id_jornal, :id_template, :num_pagina, :nom_pagina)';

		$numPagina = $this->GetNextPageNum($pagina->idJornal);

        $stm = $conn->prepare($sql);
        $stm->bindParam(':id_jornal', $pagina->idJornal);
        $stm->bindParam(':id_template', $pagina->idTemplate);
        $stm->bindParam(':num_pagina', $numPagina);
        $stm->bindParam(':nom_pagina', $pagina->nomPagina);
        $stm->execute();

        $pagina->idPagina = $conn->lastInsertId();

		if ($pagina->paginaDado != null && sizeof($pagina->paginaDado) > 0) {
			$paginaDadoRep = new PaginaDadoRepository();

			foreach ($pagina->paginaDado as $paginaDado) {
				$paginaDado->idPagina = $pagina->idPagina;

				if ($paginaDado->idPaginaDado != null) {
					$paginaDadoRep->Update($paginaDado);
				} else {
					$paginaDadoRep->Insert($paginaDado);
				}
			}
		}

        return $stm->rowCount() > 0;
    }

    function Update(Pagina &$pagina)
    {
        $conn = $this->db->getConnection();

        $sql = 'UPDATE 
                    tb_pagina 
                SET 
                    id_template = :idTemplate, 
                    nom_pagina = :nomPagina
                WHERE 
                    id_pagina = :idPagina';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':idTemplate', $pagina->newIdTemplate);
        $stm->bindParam(':nomPagina', $pagina->nomPagina);
        $stm->bindParam(':idPagina', $pagina->idPagina);
        $stm->execute();

		$paginaDadoRep = new PaginaDadoRepository();

		if ($pagina->newIdTemplate != null && $pagina->newIdTemplate != $pagina->idTemplate) {
			$paginaDadoRep->DeleteAllByPage($pagina->idPagina);
		}

		if ($pagina->paginaDado != null && sizeof($pagina->paginaDado) > 0) {
			foreach ($pagina->paginaDado as $paginaDado) {
				if ($paginaDado->idPaginaDado != null) {
					$paginaDadoRep->Update($paginaDado);
				} else {
					$paginaDadoRep->Insert($paginaDado);
				}
			}
		}

        return $stm->rowCount() > 0;
    }
    
    function Delete(Pagina &$pagina)
    {
        $conn = $this->db->getConnection();

		$paginaDadoRep = new PaginaDadoRepository();
		$paginaDadoRep->DeleteAllByPage($pagina->idPagina);

        $sql = 'DELETE FROM tb_pagina WHERE id_pagina = :idPagina';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':idPagina', $pagina->idPagina);
        $stm->execute();

		$this->UpdatePageNum($pagina);

		$result = $this->GetList($pagina->idJornal);

		return $result;
    }

    function UpdatePageNum(Pagina $pagina) {
		$conn = $this->db->getConnection();

		$sql = 'UPDATE tb_pagina SET num_pagina = num_pagina -1 WHERE id_jornal = :idJornal AND num_pagina > :numPagina';

		$stm = $conn->prepare($sql);
		$stm->bindParam(':idJornal', $pagina->idJornal);
		$stm->bindParam(':numPagina', $pagina->numPagina);
		$stm->execute();
	}

	function GetNextPageNum($idJornal) {
		$conn = $this->db->getConnection();

		$sql = 'SELECT MAX(num_pagina) FROM tb_pagina WHERE id_jornal = :id_jornal';

		$stm = $conn->prepare($sql);
		$stm->bindParam(':id_jornal', $idJornal);
		$stm->execute();

		$result = $stm->fetchColumn();

		return $result != null ? $result + 1 : 1;
	}
}