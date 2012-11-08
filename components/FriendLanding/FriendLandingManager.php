<?php

class FriendLandingManager implements IFriendLandingManager
{
    private $friendLandingDao;
    private $dealDao;
    private $customerDao;
    private $rewardDao;

    private function fillFriendReward($friendDeal)
    {
        $this->rewardDao->fillRewardById($friendDeal->reward);
    }

    function __construct($dealDao, $friendLandingDao, $customerDao, $rewardDao)
    {
        $this->friendLandingDao = $friendLandingDao;
        $this->dealDao = $dealDao;
        $this->customerDao = $customerDao;
        $this->rewardDao = $rewardDao;
    }

    public function SaveFriendLandingManager($campaign)
    {
        foreach ($campaign->friendLandings as $friend)
        {
             $this->friendLandingDao->insertFriendLanding($campaign, $friend);
        }

    }
    public function showFriendLanding($friendDeal)
    {
        catbeeLayoutComp($layout, "friendLanding", $friendDeal);
        catbeeLayout($layout, 'friendLanding');
    }

    public function startSharedDeal($friendDeal)
    {
        RestLogger::log("FriendLandingManager::startSharedDeal before", $friendDeal);

        $parentDeal = $this->dealDao->getDealById($friendDeal->parentDealId);
        RestLogger::log("FriendLandingManager::startSharedDeal parent deal ", $parentDeal);

        $this->fillFriendReward($friendDeal);
        RestLogger::log("FriendLandingManager::startSharedDeal reward ", $friendDeal->reward);

        $friendDeal->friend = $this->customerDao->loadCustomerById($parentDeal->customer);

        //2. get reward by parent deal

        $this->friendLandingDao->GetFriendLanding($parentDeal->campaign);
        //todo move to strategy
        $friendDeal->landing = $parentDeal->campaign->friendLandings[0];

        RestLogger::log("FriendLandingManager::startSharedDeal landing ", $friendDeal->landing);

        $this->showFriendLanding($friendDeal);
    }
}
