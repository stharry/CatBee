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
        $this->jsonRewardAdapter = new JsonLandingRewardAdapter();
        $this->jsonDealAdapter = new JsonLeaderDealAdapter();

    }

    private function sentToToArray($sendTo)
    {
        $result = '';

        foreach ($sendTo as $customer)
        {
            $result .= $customer->email.',';

        }
        return $result;
    }

    public function toArray($obj)
    {
        return array(
            'id' => $obj->id,
            'status' => $obj->status,
            'sendFrom' => $obj->sendFrom->email,
            'sendTo' => $this->sentToToArray($obj->sendTo),
            'message' => $obj->message,
            'link' => $obj->link,
            'subject' => $obj->subject,
            'context' => $this->jsonShareContextAdapter->toArray($obj->context),
            'reward' => $this->jsonRewardAdapter->toArray($obj->reward),
            'store' => $this->jsonStoreAdapter->toArray($obj->store)
        );
    }

    private function sentToFromArray($sendTo)
    {
        $result = array();

        foreach (explode(',', $sendTo) as $email)
        {
            $customer = new Customer($email);

            array_push($result, $customer);
        }
        return $result;
    }

    public function fromArray($obj)
    {
        $share = new Share();

        $share->id = $obj['id'];
        $share->status = $obj['status'];
        $share->sendFrom = new Customer($obj["sendFrom"]);
        $share->sendTo = $this->sentToFromArray($obj["sendTo"]);
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
