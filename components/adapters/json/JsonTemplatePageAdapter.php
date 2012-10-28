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
        $templatePage->url = $obj["url"];
        $templatePage->type = $obj["type"];

        return$templatePage;
    }
}
