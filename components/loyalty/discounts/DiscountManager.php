<?php

class DiscountManager implements IDiscountManager
{
    private $restrictionManager;
    private $rewardDao;
    private $dealShareDao;

    private function getReward($order)
    {
        $share = new Share();
        $share->id = $order->activeShareId;

        $this->dealShareDao->fillDealShareById($share);

        $reward = new LandingReward();
        $reward->id = $share->reward->id;

        $this->rewardDao->fillLandingRewardById($reward);

    }

    function __construct($restrictionManager, $rewardDao, $dealShareDao)
    {
        $this->restrictionManager = $restrictionManager;
        $this->rewardDao = $rewardDao;
        $this->dealShareDao = $dealShareDao;
    }

    public function applyDiscount($order)
    {
        $reward = $this->getReward($order);

        $discountedItems = $this->restrictionManager->getValidOrderItems($order);

        if ($discountedItems)
        {
            //todo need to separate percentage and value discount
            //todo need to indication about leader or friend...
            foreach ($discountedItems as $item)
            {
                $item->discount = $reward->friendReward->value;
                $item->couponCode = $reward->friendReward->code;
            }
            return true;

        }
        else
        {
            return false;
        }
    }
}
