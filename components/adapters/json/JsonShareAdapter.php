<?php

class JsonShareAdapter implements IModelAdapter
{
    private $jsonShareContextAdapter;
    private $jsonRewardAdapter;
    private $jsonDealAdapter;
    private $targetAdapter;

    function __construct()
    {
        $this->jsonShareContextAdapter = new JsonShareContextAdapter();
        $this->jsonRewardAdapter = new JsonLandingRewardAdapter();
        $this->jsonDealAdapter = new JsonLeaderDealAdapter();
        $this->targetAdapter = new JsonShareTargetAdapter();

    }

    public function toArray($obj)
    {
        //todo add targets
        return array(
            'id' => $obj->id,
            'status' => $obj->status,
            'message' => $obj->message,
            'customMessage' => $obj->customMessage,
            'subject' => $obj->subject,
            'context' => $this->jsonShareContextAdapter->toArray($obj->context),
            'reward' => $this->jsonRewardAdapter->toArray($obj->reward),
        );
    }

    public function fromArray($obj)
    {
        $share = new Share();

        $share->id = $obj['id'];
        $share->status = $obj['status'];
        $share->message = $obj["message"];
        $share->customMessage = $obj["customMessage"];
        $share->subject = $obj["subject"];
        $share->context = $this->jsonShareContextAdapter->fromArray($obj["context"]);
        $share->reward = $this->jsonRewardAdapter->fromArray($obj["reward"]);
        $share->deal = $this->jsonDealAdapter->fromArray($obj['deal']);

        $share->targets = array();
        foreach ($obj['targets'] as $target)
        {
            array_push($share->targets, $this->targetAdapter->fromArray($target));
        }
        return $share;
    }
}
