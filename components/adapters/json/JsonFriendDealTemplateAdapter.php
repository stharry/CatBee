<?php

include_once("JsonSingleRewardAdapter.php");
include_once("JsonCustomerAdapter.php");
include_once("JsonStoreAdapter.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/FriendDealTemplate.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IModelAdapter.php");

class JsonFriendDealTemplateAdapter implements IModelAdapter
{
    private $customerAdapter;
    private $storeAdapter;
    private $rewardAdapter;

    function __construct()
    {
        $this->customerAdapter = new JsonCustomerAdapter();
        $this->storeAdapter = new JsonStoreAdapter();
        $this->rewardAdapter = new JsonSingleRewardAdapter();
    }

    public function toArray($obj)
    {
        return array(
            "leader" => $this->customerAdapter->toArray($obj->leader),
            "friend" => $this->customerAdapter->toArray($obj->friend),
            "reward" => $this->rewardAdapter->toArray($obj->reward),
            "store" => $this->storeAdapter->toArray($obj->store)
        );
    }

    public function fromArray($obj)
    {
        $friendDealTemplate = new FriendDealTemplate();

        $friendDealTemplate->friend = $this->customerAdapter->fromArray($obj["friend"]);
        $friendDealTemplate->leader = $this->customerAdapter->fromArray($obj["leader"]);
        $friendDealTemplate->store = $this->storeAdapter->fromArray("store");
        $friendDealTemplate->reward = $this->rewardAdapter->fromArray("reward");

        return $friendDealTemplate;
    }
}
