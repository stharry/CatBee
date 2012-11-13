<?php

class JsonFriendDealAdapter implements IModelAdapter
{

    private $shareAdapter;
    private $orderAdapter;

    function __construct()
    {
        $this->shareAdapter = new JsonShareAdapter();
        $this->orderAdapter = new JsonOrderAdapter();
    }
    public function toArray($obj)
    {
        // TODO: Implement toArray() method.
    }

    public function fromArray($obj)
    {
        $friendDeal = new FriendDeal();
        $friendDeal->share = $this->shareAdapter->fromArray($obj['share']);
        $friendDeal->order = $this->orderAdapter->fromArray($obj['order']);

        return $friendDeal;
    }
}
