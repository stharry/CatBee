<?php

class FriendLandingManager implements IFriendLandingManager
{
    private $friendLandingDao;
    private $dealDao;
    private $customerDao;
    private $rewardDao;
    private $campaignDao;
    private $dealShareDao;
    private $storeManager;
    private $impressionManager;

    private function fillLandingReward($friendDeal)
    {
        $this->rewardDao->fillLandingRewardById($friendDeal->share->reward);
    }

    private function getShareById($friendDeal)
    {
        RestLogger::log('FriendLandingManager::getShareById begin ', $friendDeal->share);

        $this->dealShareDao->fillDealShareById($friendDeal->share);

        RestLogger::log('FriendLandingManager::getShareById end');
    }

    function __construct($dealDao, $friendLandingDao,
                         $customerDao, $rewardDao,
                         $campDao, $dealShareDao, $storeManager,$impressionManager)
    {
        $this->friendLandingDao = $friendLandingDao;
        $this->dealDao = $dealDao;
        $this->customerDao = $customerDao;
        $this->rewardDao = $rewardDao;
        $this->campaignDao = $campDao;
        $this->dealShareDao = $dealShareDao;
        $this->storeManager = $storeManager;
        $this->impressionManager = $impressionManager;
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
        RestLogger::log('FriendLandingManager::showFriendLanding deal: ', $friendDeal);
        RestLogger::log('FriendLandingManager::showFriendLanding store: ', $Store);

        catbeeLayoutComp($layout, "friendLanding", array($friendDeal,$Store));
        //catbeeLayoutComp($layout, "friendLanding", $friendDeal);
        catbeeLayout($layout, 'friendLanding');
    }

    public function startSharedDeal($friendDeal)
    {
        RestLogger::log("FriendLandingManager::startSharedDeal before", $friendDeal);
        //TODO - combine to 3 below call to one DB call

        $this->getShareById($friendDeal);
        $parentDeal = $this->dealDao->getDealById($friendDeal->share->deal->id);
        RestLogger::log("FriendLandingManager::startSharedDeal parent deal ", $parentDeal);
        $this->fillLandingReward($friendDeal);

        RestLogger::log("FriendLandingManager::startSharedDeal reward ", $friendDeal->share->reward);
        $friendDeal->friend = $this->customerDao->loadCustomerById($parentDeal->customer);

        $CampaignFilter = new CampaignFilter();
        $CampaignFilter->campId = $parentDeal->campaign->id;
        $Camp = $this->campaignDao->getCampaigns($CampaignFilter);

        $this->friendLandingDao->GetFriendLanding($parentDeal->campaign);
        $friendDeal->landing = $parentDeal->campaign->friendLandings[0];
        RestLogger::log("FriendLandingManager::startSharedDeal landing ", $friendDeal->landing);
        //Save the Impression
        $this->impressionManager->saveImpression($friendDeal->share);

        $this->showFriendLanding($friendDeal,$Camp[0]->store);
    }
}
