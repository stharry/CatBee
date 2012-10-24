<?php

includeModel('campaign');
includeModel('FriendDeal');
includeModel('components/IFriendLandingManager');
IncludeComponent('rest', 'RestLogger');
IncludeComponent('dao/PDO', 'PdoFriendLandingDao');

class FriendLandingManager implements IFriendLandingManager
{
    private $friendLandingDao;
    private $dealDao;

    private function getFriendReward($leaderDeal)
    {


    }

    function __construct($dealDao, $friendLandingDao)
    {
        $this->friendLandingDao = $friendLandingDao;
        $this->dealDao = $dealDao;
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

    public function startSharedDeal($parentDealId)
    {
        $parentDeal = $this->dealDao->getDealById($parentDealId);
        RestLogger::log("FriendLandingManager::startSharedDeal parent deal ", $parentDeal);

        $friendDeal = new FriendDeal();

        $friendDeal->reward = $this->getFriendReward($parentDeal);

        //2. get reward by parent deal

        $this->friendLandingDao->GetFriendLanding($parentDeal->campaign);
        //todo move to strategy
        $friendDeal->landing = $parentDeal->campaign->friendLandings[0];

        RestLogger::log("FriendLandingManager::startSharedDeal landing ", $friendDeal->landing);

        $this->showFriendLanding($friendDeal);
    }
}
