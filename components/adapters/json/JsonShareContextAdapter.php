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
        //todo: need to data base is

        $contextType = "unknown";

        switch ($obj->id)
        {
            case 1:
                $contextType = "email";
                break;

            case 2:
                $contextType = "facebook";
                break;

            case 3:
                $contextType = "twitter";
                break;

            case 1024:
                $contextType = "tribzi";
                break;
        }

        return array(
            'type' => $contextType,
            'application' => $this->applicationAdapter->toArray($obj->application));
    }

    public function fromArray($obj)
    {
        $shareContext = new ShareContext();

        if (is_array($obj))
        {
            $shareContext->type = strtolower($obj["type"]);
            if (isset($obj['application']))
            {
                $shareContext->application =
                    $this->applicationAdapter->fromArray($obj['application']);
            }
        }
        else
        {
            $shareContext->type = strtolower($obj);
        }

        //todo: need to data base is
        switch ($shareContext->type)
        {
            case "email":
                $shareContext->id = 1;
                break;

            case "facebook":
                $shareContext->id = 2;
                break;

            case "twitter":
                $shareContext->id = 3;
                break;

            case "tribzi":
                $shareContext->id = 1024;
                break;

            default:
                $shareContext->id = 1;
                break;
        }

        return $shareContext;
    }
}
