<?php

class JsonShareContextAdapter implements IModelAdapter
{

    private $applicationAdapter;

    function __construct()
    {
        $this->applicationAdapter = new JsonShareApplicationAdapter();
    }

    public function toArray($obj)
    {
        if (!$obj)
        {
            return array();
        }
        elseif (is_array($obj))
        {
            $contexts = array();

            foreach ($obj as $context)
            {
                array_push($contexts, $this->SingleContextToArray($context));
            }

            return $contexts;

        }

        return $this->SingleContextToArray($obj);
    }

    private function SingleContextToArray($obj)
    {
        return array(
            'type'          => $obj->type,
            'link'          => $obj->link,
            'message'       => $obj->message,
            'customMessage' => $obj->customMessage,
            'uid'           => $obj->uid,
            'application'   => $this->applicationAdapter->toArray($obj->application));
    }

    public function fromArray($obj)
    {


        if (is_array($obj))
        {
            $shareContext = new ShareContext($obj['type']);

            $shareContext->link          = $obj['link'];
            $shareContext->message       = $obj['message'];
            $shareContext->customMessage = $obj['customMessage'];
            $shareContext->uid           = $obj['uid'];

            if (isset($obj['application']))
            {
                $shareContext->application =
                    $this->applicationAdapter->fromArray($obj['application']);
            }
        }
        else
        {
            $shareContext = new ShareContext($obj);
        }

        return $shareContext;
    }
}
