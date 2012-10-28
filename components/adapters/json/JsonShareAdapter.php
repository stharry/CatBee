<?php

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
        return array(
            'sendFrom' => $obj->sendFrom,
            'sendTo' => $obj->sendTo,
            'message' => $obj->message,
            'link' => $obj->link,
            'subject' => $obj->subject
        );
    }

    public function fromArray($obj)
    {
        $share = new Share();

        $share->sendFrom = $obj["sendFrom"];
        $share->sendTo = $obj["sendTo"];
        $share->message = $obj["message"];
        $share->link = $obj["link"];
        $share->subject = $obj["subject"];

        $share->store = $this->jsonStoreAdapter->fromArray($obj["store"]);
        $share->context = $this->jsonShareContextAdapter->fromArray($obj["context"]);
        $share->reward = $this->jsonRewardAdapter->fromArray($obj["reward"]);

        return $share;
    }
}
