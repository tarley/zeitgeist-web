<?php

class TemplateController extends BaseController
{
    function ProcessRequest($action)
    {
        try {
            switch ($action) {
                case "get":
                    $templateId = isset($_GET['key']) ? $_GET['key'] : null;
                    $this->ActionGetThis($templateId);
                    break;
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

    function ActionGetThis($template)
    {
        $templateRepository = new TemplateRepository();
        $result = $templateRepository->GetThis($template);

        $template = new Template();
        $template->FillByDB($result);

        if (!$template->template)
            throw new Warning("Template não encontrado");

        ToWrappedJson($template);
    }

    function ActionGetList()
    {
        $templateRepository = new TemplateRepository();
        $result = $templateRepository->GetList();

        $listTemplate = array();

        foreach ($result as $dbTemplate) {
            $modelTemplate = new Template();
            $modelTemplate->FillByDB($dbTemplate);
            $listTemplate[] = $modelTemplate;
        }

        ToWrappedJson($listTemplate);
    }

  

    

   
}
