<?php

class JsonStoreAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        return
            array("authCode" => $obj->authCode,
                "description" => $obj->description,
                "url" => $obj->url,
                'logoUrl' => $obj->logoUrl,
                'email' => $obj->email
            );
    }

    public function fromArray($obj)
    {
        $store = new Store();

        if (is_array($obj))
        {
            $store->authCode = $obj[ "authCode" ];
            $store->description = $obj[ "description" ];
            $store->url = $obj[ "url" ];
            $store->logoUrl = $obj[ "logoUrl" ];
            $store->email = $obj["email"];
        }
        else
        {
            $store->authCode = $obj;
        }

        return $store;
    }
}
