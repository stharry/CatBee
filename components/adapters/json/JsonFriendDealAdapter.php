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
        return array(
            'share' => $this->shareAdapter->toArray($obj->share),
            'order' => $this->orderAdapter->toArray($obj->order)
        );
    }

    public function fromArray($obj)
    {
        $friendDeal = new FriendDeal();
        $friendDeal->share = $this->shareAdapter->fromArray($obj['share']);
        $friendDeal->order = $this->orderAdapter->fromArray($obj['order']);

        return $friendDeal;
    }
}
