<?php

class SituacaoController extends BaseController
{
    function ProcessRequest($action)
    {
        try {
            switch ($action) {
                case "list":
                    $this->ActionGetList();
                    break;
                default:
                    ToErrorJson("Action not found");
            }
        } catch (Warning $e) {
            ToErrorJson($e->getMessage());
        } catch (Exception $e) {
            ToExceptionJson($e);
        }
    }

   function GetList()
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT 
                    id_situacao,desc_situacao
            FROM 
                td_situacao
            WHERE 
                id_situacao = :id_situacao';


      $stm = $conn->prepare($sql);
        $stm->bindParam(':id_situacao', $id_situacao);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }



   
}
