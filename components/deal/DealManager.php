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
        includeModel("slogan");
        includeModel("sliderPhrase");
        includeModel("leaderReward");

//$temp = new slogan('a','b');
        $slogan = slogan::getSlogan('DefCamp');

//temp vad todo: remove it
        $slogan->firstLine = "You got the power!!!";
        $slogan->secondLine = "Create an Awesome Deal";

        $temp1 = new sliderPhrase('a', 'b');
        $sliderPhrase = $temp1->getSliderPhrase('DefCamp');

        $temp2 = new leaderReward('1', 'b', 'a', 'd', 10);
        $leaderReward = $temp2->getleaderReward('DefCamp');

        $GLOBALS["page_title"] = "CatBee Landing Page";
        $GLOBALS["title"] = $slogan->firstLine;
        $GLOBALS["subtitle"] = $slogan->secondLine;

        catbeeLayoutComp($layout, "inputforms/landing", $sliderPhrase);

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
