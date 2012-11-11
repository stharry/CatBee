<?php

class JsonFriendDealAdapter implements IModelAdapter
{

    private $rewardAdapter;
    private $orderAdapter;

    function __construct()
    {
        $this->rewardAdapter = new JsonSingleRewardAdapter();
        $this->orderAdapter = new JsonOrderAdapter();
    }
    public function toArray($obj)
    {
        // TODO: Implement toArray() method.
    }

    public function fromArray($obj)
    {
        $friendDeal = new FriendDeal();
        $friendDeal->parentDealId = $obj['parentDealId'];
        $friendDeal->reward = $this->rewardAdapter->fromArray($obj['reward']);
        $friendDeal->order = $this->orderAdapter->fromArray($obj['order']);

        return $friendDeal;
    }
}
