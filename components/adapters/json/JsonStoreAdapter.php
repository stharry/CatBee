<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/Store.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IModelAdapter.php");


class JsonStoreAdapter implements  IModelAdapter
{

    public function toArray($obj)
    {
        return
            array("authCode" => $obj->authCode,
                "description" => $obj->description,
                "url" => $obj->url);
    }

    public function fromArray($obj)
    {
        $store = new Store();

        $store->authCode = $obj["authCode"];
        $store->description = $obj["description"];
        $store->url = $obj["url"];

        return $store;
    }
}