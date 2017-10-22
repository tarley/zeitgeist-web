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

    function Insert(PaginaImagem &$paginaImagem)
    {
        $conn = $this->db->getConnection();

        $sql = 'INSERT INTO tb_pagina_imagem (id_pagina_dado, valor_pagina_imagem) VALUES (:idPaginaDado, :valorPaginaImagem)';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':idPaginaDado', $pagina->idPaginaDado);
        $stm->bindParam(':valorPaginaImagem', base64_decode($pagina->valorPaginaImagem));
        $stm->execute();

        $pagina->idPaginaImagem = $conn->lastInsertId();

        return $stm->rowCount() > 0;
    }

    function Update(PaginaImagem &$paginaImagem)
    {
        $conn = $this->db->getConnection();

        $sql = 'UPDATE 
                    tb_pagina_imagem
                SET 
                    valor_pagina_imagem = :valorPaginaImagem
                WHERE 
                    id_pagina_imagem = :idPaginaImagem';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':valorPaginaImagem', base64_decode($paginaImagem->valorPaginaImagem));
        $stm->bindParam(':idPaginaImagem', $paginaImagem->idPaginaImagem);
        $stm->execute();

        return $stm->rowCount() > 0;
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