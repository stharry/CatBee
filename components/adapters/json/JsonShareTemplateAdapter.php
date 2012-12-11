<?php

class JsonShareTemplateAdapter implements IModelAdapter
{

    private $jsonStoreAdapter;
    private $jsonTemplatePageAdapter;
    private $jsonShareContextAdapter;
    private $jsonTemplateAdapter;
    private $jsonTargetAdapter;


    function __construct()
    {
        $this->jsonStoreAdapter        = new JsonStoreAdapter();
        $this->jsonTemplatePageAdapter = new JsonTemplatePageAdapter();
        $this->jsonShareContextAdapter = new JsonShareContextAdapter();
        $this->jsonTemplateAdapter     = new JsonTemplateAdapter();
        $this->jsonTargetAdapter       = new JsonShareTargetAdapter();
    }

    private function singleShareTemplateToArray($shareTemplate)
    {
        $shareTemplateProps =
            array(
                "message"       => $shareTemplate->messge,
                "customMessage" => $shareTemplate->customMessage,
                "store"         => $this->jsonStoreAdapter->toArray($shareTemplate->store),
                "shareContext"  => $this->jsonShareContextAdapter->toArray($shareTemplate->shareContext),
                "templatePage"  => $this->jsonTemplatePageAdapter->toArray($shareTemplate->templatePage),
                'target'        => $this->jsonTargetAdapter->toArray($shareTemplate->target)
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
        $shareTemplate                = new ShareTemplate();
        $shareTemplate->message       = $obj[ 'message' ];
        $shareTemplate->customMessage = $obj[ 'customMessage' ];
        $shareTemplate->store         = $this->jsonStoreAdapter->fromArray($obj[ "store" ]);
        $shareTemplate->shareContext  = $this->jsonShareContextAdapter->fromArray($obj[ "shareContext" ]);
        $shareTemplate->templatePage  = $this->jsonTemplatePageAdapter->fromArray($obj[ "templatePage" ]);
        $shareTemplate->target        = $this->jsonTargetAdapter->fromArray($obj[ 'target' ]);

        return $shareTemplate;
    }

}
