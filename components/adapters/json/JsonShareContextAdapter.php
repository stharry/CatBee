<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/ShareContext.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IModelAdapter.php");

class JsonShareContextAdapter implements IModelAdapter
{

    public function toArray($obj)
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
        }

        return array("type" => $contextType);
    }

    public function fromArray($obj)
    {
        $shareContext = new ShareContext();
        $shareContext->type = $obj["type"];

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

            default:
                $shareContext->id = 1;
                break;
        }

        return $shareContext;
    }
}
