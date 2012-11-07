<?php

class JsonShareAdapter implements IModelAdapter
{
    private $jsonStoreAdapter;
    private $jsonShareContextAdapter;
    private $jsonRewardAdapter;
    private $jsonDealAdapter;

    function __construct()
    {
        $this->jsonStoreAdapter = new JsonStoreAdapter();
        $this->jsonShareContextAdapter = new JsonShareContextAdapter();
        $this->jsonRewardAdapter = new JsonSingleRewardAdapter();
        $this->jsonDealAdapter = new JsonLeaderDealAdapter();

    }

    public function toArray($obj)
    {
        return array(
            'sendFrom' => $obj->sendFrom,
            'sendTo' => $obj->sendTo,
            'message' => $obj->message,
            'link' => $obj->link,
            'subject' => $obj->subject,
            'context' => $this->jsonShareContextAdapter->toArray($obj->context),
            'reward' => $this->jsonRewardAdapter->toArray($obj->reward),
            'store' => $this->jsonStoreAdapter->toArray($obj->store)
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
        $share->deal = $this->jsonDealAdapter->fromArray($obj['deal']);

        return $share;
    }
}
