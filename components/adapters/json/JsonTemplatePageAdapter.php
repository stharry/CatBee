<?php

class JsonTemplatePageAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        return array("context" => $obj->context);
    }

    public function fromArray($obj)
    {
        $templatePage = new TemplatePage();

        if ($obj['url'])
        {
            $templatePage->url = $obj["url"];
        }
        else if ($obj['context'])
        {
            $templatePage->context = json_encode($obj['context']);
        }
        $templatePage->type = $obj["type"];


        return$templatePage;
    }
}
