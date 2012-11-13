<?php

class JsonStoreAdapter implements IModelAdapter
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

        if (is_array($obj))
        {
            $store->authCode = $obj[ "authCode" ];
            $store->description = $obj[ "description" ];
            $store->url = $obj[ "url" ];
        }
        else
        {
            $store->authCode = $obj;
        }

        return $store;
    }
}
