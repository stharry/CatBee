<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/Store.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IModelAdapter.php");


class JsonStoreAdapter implements  IModelAdapter
{

    public function toArray($obj)
    {
        // TODO: Implement toArray() method.
    }

    public function fromArray($obj)
    {
        $store = new Store();

        $store->authCode = $obj["authCode"];

        return $store;
    }
}
