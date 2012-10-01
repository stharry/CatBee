<?php

include_once("JsonStoreAdapter.php");
include_once("JsonShareContextAdapter.php");

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/Share.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IModelAdapter.php");

class JsonShareAdapter implements IModelAdapter
{
    private $jsonStoreAdapter;
    private $jsonShareContextAdapter;

    function __construct()
    {
        $this->jsonStoreAdapter = new JsonStoreAdapter();
        $this->jsonShareContextAdapter = new JsonShareContextAdapter();

    }

    public function toArray($obj)
    {
        // TODO: Implement toArray() method.
    }

    public function fromArray($obj)
    {
        $share = new Share();

        $share->sendFrom = $obj["sendFrom"];
        $share->sendTo = $obj["sendTo"];
        $share->message = $obj["message"];

        $share->store = $this->jsonStoreAdapter->fromArray($obj["store"]);
        $share->context = $this->jsonShareContextAdapter->fromArray($obj["context"]);

        return $share;
    }
}
