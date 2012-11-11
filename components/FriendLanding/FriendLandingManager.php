<?php

class FriendLandingManager implements IFriendLandingManager
{
    private $friendLandingDao;
    private $dealDao;
    private $customerDao;
    private $rewardDao;
    private $campaignDao;
    private $storeManager;

    private function fillFriendReward($friendDeal)
    {
        $this->rewardDao->fillRewardById($friendDeal->reward);
    }

    function __construct($dealDao, $friendLandingDao, $customerDao, $rewardDao,$campDao,$storeManager)
    {
        $this->friendLandingDao = $friendLandingDao;
        $this->dealDao = $dealDao;
        $this->customerDao = $customerDao;
        $this->rewardDao = $rewardDao;
        $this->campaignDao = $campDao;
        $this->storeManager = $storeManager;
    }

    public function SaveFriendLandingManager($campaign)
    {
        foreach ($campaign->friendLandings as $friend)
        {
             $this->friendLandingDao->insertFriendLanding($campaign, $friend);
        }

    }
    public function showFriendLanding($friendDeal,$Store)
    {
        catbeeLayoutComp($layout, "friendLanding", array($friendDeal,$Store));
        //catbeeLayoutComp($layout, "friendLanding", $friendDeal);
        catbeeLayout($layout, 'friendLanding');
    }

    public function startSharedDeal($friendDeal)
    {
        RestLogger::log("FriendLandingManager::startSharedDeal before", $friendDeal);

        if ($friendDeal->parentDealId)
        {
            $parentDeal = $this->dealDao->getDealById($friendDeal->parentDealId);
        }
        else if ($friendDeal->order)
        {
            $parentDeal = $this->dealDao->getParentDealByOrderId($friendDeal->order->id);
        }
        RestLogger::log("FriendLandingManager::startSharedDeal parent deal ", $parentDeal);

        $this->fillFriendReward($friendDeal);
        RestLogger::log("FriendLandingManager::startSharedDeal reward ", $friendDeal->reward);

        $friendDeal->friend = $this->customerDao->loadCustomerById($parentDeal->customer);


        //Get The Store From The Campaign
        $CampaignFilter = new CampaignFilter();
        $CampaignFilter->Lazy = true;
        $CampaignFilter->CampID= $parentDeal->campaign->id;
        $Camp = $this->campaignDao->getCampaigns($CampaignFilter);
        $StoreBranchFilter = new StoreBranchFilter();
        $StoreBranchFilter->ShopID = $Camp[0]->store;
        $Branch = $this->storeManager->getStoreBranches($StoreBranchFilter);
        //2. get reward by parent deal
        $this->friendLandingDao->GetFriendLanding($parentDeal->campaign);
        //todo move to strategy
        $friendDeal->landing = $parentDeal->campaign->friendLandings[0];

        RestLogger::log("FriendLandingManager::startSharedDeal landing ", $friendDeal->landing);
        $this->showFriendLanding($friendDeal,$Branch);
    }
}
