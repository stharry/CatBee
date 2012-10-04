<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/model/components/IDealManager.php");


class DealManager implements IDealManager
{
    private $campaignManager;
    private $dealDao;

    function __construct($campaignManager, $dealDao)
    {
        $this->campaignManager = $campaignManager;
        $this->dealDao = $dealDao;
    }

    private function showLeaderDeal($leaderDeal)
    {
        $GLOBALS["leaderDeal"] = $leaderDeal;

        catbeeLayoutComp($layout, "landing", $leaderDeal);
        catbeeLayoutComp($layout, "share", $leaderDeal);
        catbeeLayoutComp($layout, "sliderOptions", $leaderDeal);

        catbeeLayout($layout, 'landing');

    }


    private function createPendingDeal($landing, $order)
    {
        $leaderDeal = new LeaderDeal();

        $leaderDeal->customer = $order->customer;
        $leaderDeal->date = time();
        $leaderDeal->landing = $landing;
        $leaderDeal->order = $order;
        $leaderDeal->status = LeaderDeal::$STATUS_PENDING;
        $leaderDeal->selectedLandingReward = $landing->landingRewards[0]->leaderReward->value;
        $this->dealDao->insertDeal($leaderDeal);
        return $leaderDeal;
    }


    public function pushDeal($order)
    {

        $campaign = $this->campaignManager->chooseCampaign($order);
        $leaderLanding = $this->campaignManager->chooseLeaderLanding($campaign, $order);
        $leaderDeal = $this->createPendingDeal($leaderLanding, $order);
        $this->showLeaderDeal($leaderDeal);
        return $leaderDeal;
    }
}
