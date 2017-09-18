<?php

class DadosTemplateController extends BaseController
{
    function ProcessRequest($action)
    {
        try {
            switch ($action) {
                case "get":
                    $idTemplateDado = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionGetThis($idTemplateDado);
                    break;
                case "list":
                    $idTemplateDado = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionGetList($idTemplateDado);
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

    function ActionGetThis($idTemplateDado)
    {
        $dadosTemplateRepository = new DadosTemplateRepository();
        $result = $dadosTemplateRepository->GetThis($id_template_dado);

        $dadosTemplate = new DadosTemplate();
        $dadosTemplate->FillByDB($result);

        if (!$dadosTemplate->dadosTemplate)
            throw new Warning("Template não encontrado");

        ToWrappedJson($dadosTemplate);
    }

    function ActionGetList($idTemplateDado)
    {
        
        $dadosTemplateRepository = new DadosTemplateRepository();
        $result = $dadosTemplateRepository->GetList($idTemplate);

        $listDadosTemplate = array();

        foreach ($result as $dbDadosTemplate) {
            $modelDadosTemplate = new DadosTemplate();
            $modelDadosTemplate->FillByDB($dbDadosTemplate);
            $listDadosTemplate[] = $modelDadosTemplate;
        }

        ToWrappedJson($listUsuario);
    }

    

   

}
