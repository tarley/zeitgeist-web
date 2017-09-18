<?php

class UsuarioRepository extends BaseRepository
{

    function GetThis($codUsuario)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
                id_template_dado,id_template,id_template_dado,chave_template_dado,desc_template_dado
            FROM 
                tb_template_dado
            WHERE 
               id_template = :id_template';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':id_template', $idTemplate);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    function GetList()
    {

        $sql = 'SELECT 
                id_template_dado,id_template, id_tipo_template_dado,chave_template_dado,desc_template_dado
            FROM 
                tb_template_dado';

        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

   

  
}