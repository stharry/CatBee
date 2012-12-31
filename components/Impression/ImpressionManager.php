<?php

class ImpressionManager
{

    private $PdoImpression;

    function __construct($PdoImpression)
    {
        $this->PdoImpression = $PdoImpression;

        RestLogger::log("PdoImpression  created...");
    }

    public function saveImpression($share)
    {
        $impression = new Impression();
        $impression->share = $share->id;
        $impression->timeStamp = date("Y-m-d h:i:s");
        $this->PdoImpression->InsertImpression($impression);
    }

}