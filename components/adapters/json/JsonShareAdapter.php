<?php

include_once("JsonStoreAdapter.php");
include_once("JsonShareContextAdapter.php");

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/Share.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IModelAdapter.php");

class JsonShareAdapter implements IModelAdapter
{
    private $jsonStoreAdapter;
    private $jsonShareContextAdapter;
    private $jsonRewardAdapter;

    function __construct()
    {
        $this->jsonStoreAdapter = new JsonStoreAdapter();
        $this->jsonShareContextAdapter = new JsonShareContextAdapter();
        $this->jsonRewardAdapter = new JsonSingleRewardAdapter();

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
        $share->subject = $obj["subject"];

        $share->store = $this->jsonStoreAdapter->fromArray($obj["store"]);
        $share->context = $this->jsonShareContextAdapter->fromArray($obj["context"]);
        $share->reward = $this->jsonRewardAdapter->fromArray($obj["reward"]);

        return $share;
    }
}
