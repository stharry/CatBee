<?php

class JsonFriendDealAdapter implements IModelAdapter
{

    private $rewardAdapter;

    function __construct()
    {
        $this->rewardAdapter = new JsonSingleRewardAdapter();
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

        return $friendDeal;
    }
}
