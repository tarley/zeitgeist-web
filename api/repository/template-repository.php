<?php

class TemplateRepository extends BaseRepository
{

    function GetThis($id_template)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
                id_template,desc_template,desc_caminho_template 
            FROM 
                tb_template 
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
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
                id_template,desc_template,desc_caminho_template 
            FROM 
                tb_template';

        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

   
}