<?php

class JsonShareApplicationAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        return array(
            'applicationCode' => $obj->applicationCode,
            'redirectUrl' => $obj->redirectUrl
        );
    }

    public function fromArray($obj)
    {
        $app = new ShareApplication();

        $app->applicationApiKey = $obj['applicationApiKey'];
        $app->applicationCode = $obj['applicationCode'];
        $app->applicationSecret = $obj['applicationSecret'];
        $app->authorizationUrl = $obj['authorizationUrl'];
        $app->redirectUrl = $obj['redirectUrl'];

        return $app;
    }
}
