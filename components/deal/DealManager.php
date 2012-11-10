<?php

class DealManager implements IDealManager
{
    private $campaignManager;
    private $storeManager;
    private $shareManager;
    private $dealDao;

    function __construct($campaignManager, $storeManager, $shareManager, $dealDao)
    {
        $this->campaignManager = $campaignManager;
        $this->dealDao = $dealDao;
        $this->storeManager = $storeManager;
        $this->shareManager = $shareManager;
    }

    private function getCatBeeSharePoint()
    {
        return $GLOBALS[ "restURL" ] . "/CatBee/api/share/";

    }

    private function showLeaderDeal($leaderDeal)
    {
        $GLOBALS[ "leaderDeal" ] = $leaderDeal;

        catbeeLayoutComp($layout, "landing", $leaderDeal);
        catbeeLayoutComp($layout, "share", $leaderDeal);
        catbeeLayoutComp($layout, "mailForm", $leaderDeal);
        catbeeLayoutComp($layout, "facebookForm", $leaderDeal);
        catbeeLayoutComp($layout, "sliderOptions", $leaderDeal);
        catbeeLayout($layout, 'landing');

    }

    private function refreshDealProps($leaderDeal, $landing, $order)
    {
        $leaderDeal->selectedLandingReward = $landing->landingRewards[ 0 ]->leaderReward->value;
        $leaderDeal->sharePoint = $this->getCatBeeSharePoint();
        $leaderDeal->landing = $landing;
        $leaderDeal->order = $order;
    }

    private function createPendingDeal($landing, $order, $campaign)
    {
        try
        {
            RestLogger::log("aaa", $this->dealDao);

            $leaderDeal = $this->dealDao->getDealByOrder($order);

            if (!$leaderDeal)
            {
                RestLogger::log("DealManager::createPendingDeal new Deal adding");

                $leaderDeal = new LeaderDeal();

                $leaderDeal->customer = $order->customer;
                $leaderDeal->date = time();
                $leaderDeal->status = LeaderDeal::$STATUS_PENDING;

                $this->refreshDealProps($leaderDeal, $landing, $order);
                $leaderDeal->campaign = $campaign;

                $this->dealDao->insertDeal($leaderDeal);
            }
            else
            {
                $this->refreshDealProps($leaderDeal, $landing, $order);
                $leaderDeal->campaign = $campaign;
            }

            return $leaderDeal;
        }
        catch (Exception $e)
        {
            RestLogger::log("Exception: " . $e->getMessage());
            throw new Exception("", 0, $e);
        }
    }


    public function pushDeal($order)
    {
        $this->storeManager->validateBranch($order->store, $order->branch);
        RestLogger::log("DealManager::pushDeal after store validation");

        $campaign = $this->campaignManager->chooseCampaign($order);
        RestLogger::log("DealManager::pushDeal after campaign choosing ", $campaign);

        $leaderLanding = $this->campaignManager->chooseLeaderLanding($campaign, $order);
        RestLogger::log("DealManager::pushDeal after landing choosing ", $leaderLanding);

        $leaderDeal = $this->createPendingDeal($leaderLanding, $order, $campaign);

        RestLogger::log("DealManager::pushDeal after deal creation ", $leaderDeal);

        $this->showLeaderDeal($leaderDeal);
        RestLogger::log("DealManager::pushDeal after rendering");

        return $leaderDeal;
    }

    public function getDealById($dealId)
    {
        $leaderDeal = $this->dealDao->getDealById($dealId);

        //todo fill customer, store, etc. props

        return $leaderDeal;
    }

    public function updateDeal($deal)
    {
        $this->dealDao->updateDealStatus($deal);
    }

    public function addDealShare($share)
    {
        $this->shareManager->addDealShare($share);

        $share->deal->status = LeaderDeal::$STATUS_SHARED;
        $this->updateDeal($share->deal);
    }
}

