<?php

class SituacaoRepository extends BaseRepository
{

    function GetThis($codUsuario)
    {
        $conn = $this->db->getConnection();

       
       
        $sql = 'SELECT 
               id_situacao,desc_situacao
            FROM 
                tb_situacao 
            WHERE 
                id_situacao = :id_situacao';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':id_situacao', $idSituacao);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

           return $result;
    }
   
    function GetList()
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
               id_situacao,desc_situacao
            FROM 
                tb_usuario u';

        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    

 
}
