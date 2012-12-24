<?php

class JsonAdaptorAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        return
            array("authCode"    => $obj->authCode,
                  "description" => $obj->description,
                  "url"         => $obj->url,
                  'landingUrl'  => $obj->landingUrl,
                  'email'       => $obj->email
            );
    }

    public function fromArray($obj)
    {
        $adaptor = new Adaptor();

        if (is_array($obj))
        {
            $adaptor->authCode    = $obj[ "authCode" ];
            $adaptor->description = $obj[ "description" ];
            $adaptor->url         = $obj[ "url" ];
            $adaptor->landingUrl  = $obj[ "landingUrl" ];
            $adaptor->email       = $obj[ "email" ];
        }
        else
        {
            $adaptor->authCode = $obj;
        }

        return $adaptor;
    }
}
