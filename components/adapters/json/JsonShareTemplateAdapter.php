<?php

include_once("JsonStoreAdapter.php");
include_once("JsonTemplatePageAdapter.php");
include_once("JsonShareContextAdapter.php");

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/ShareTemplate.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/TemplatePage.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IModelAdapter.php");

class JsonShareTemplateAdapter implements IModelAdapter
{

    private $jsonStoreAdapter;
    private $jsonTemplatePageAdapter;
    private $jsonShareContextAdapter;

    function __construct()
    {
        $this->jsonStoreAdapter = new JsonStoreAdapter();
        $this->jsonTemplatePageAdapter = new JsonTemplatePageAdapter();
        $this->jsonShareContextAdapter = new JsonShareContextAdapter();

    }

    private function singleShareTemplateToArray($shareTemplate)
    {
        $shareTemplateProps =
            array("store" => $this->jsonStoreAdapter->toArray($shareTemplate->store),
                "shareContext" => $this->jsonShareContextAdapter->toArray($shareTemplate->shareContext),
                "templatePage" => $this->jsonTemplatePageAdapter->toArray($shareTemplate->templatePage)
            );

        return $shareTemplateProps;
    }

    public function toArray($obj)
    {

        if (is_array($obj))
        {
            $shareTemplatesProps = array();

            foreach ($obj as $shareTemplate)
            {
                array_push($shareTemplatesProps, $this->singleShareTemplateToArray($shareTemplate));
            }
            return $shareTemplatesProps;
        }
        return $this->singleShareTemplateToArray($obj);
    }

    public function fromArray($obj)
    {
        $shareTemplate = new ShareTemplate();
        $shareTemplate->store = $this->jsonStoreAdapter->fromArray($obj["store"]);
        $shareTemplate->shareContext = $this->jsonShareContextAdapter->fromArray($obj["shareContext"]);
        $shareTemplate->templatePage = $this->jsonTemplatePageAdapter->fromArray( $obj["templatePage"]);

        return $shareTemplate;
    }
}