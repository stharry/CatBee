<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/model/Reward.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/components/adapters/IModelAdapter.php");

class JsonSingleRewardAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        return
            array("value" => $obj->value,
                "code" => $obj->code,
                "type" => $obj->type,
                "description" => $obj->description,
                "typeDescription" => $obj->typeDescription);
    }

    public function fromArray($obj)
    {
        $reward = new Reward();

        $reward->value = $obj["value"];
        $reward->code = $obj["code"];
        $reward->type = $obj["type"];
        $reward->description = $obj["description"];
        $reward->typeDescription = $obj["typeDescription"];

        return $reward;
    }
}