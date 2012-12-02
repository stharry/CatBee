<?php

class DealManager implements IDealManager
{
    private $campaignManager;
    private $storeManager;
    private $shareManager;
    private $dealDao;
    private $leadManager;

    function __construct($campaignManager, $storeManager, $shareManager, $dealDao,$leadManager)
    {
        $this->campaignManager = $campaignManager;
        $this->dealDao = $dealDao;
        $this->storeManager = $storeManager;
        $this->shareManager = $shareManager;
        $this->leadManager = $leadManager;
    }

    private function getCatBeeSharePoint()
    {
        return $GLOBALS[ "restURL" ] . "/CatBee/api/deal/";

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
            RestLogger::log("DealManager:createPendingDeal begin", $this->dealDao);

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
        } catch (Exception $e)
        {
            RestLogger::log("Exception: " . $e->getMessage());
            throw new Exception("", 0, $e);
        }
    }


    public function pushDeal($order)
    {

        //TODO - What happens if the Branch Is not Validated?
        $this->storeManager->validateBranch($order->store, $order->branch);

        //Register Leading Deal If Exist
        $this->leadManager->saveLead($order,"1");

        RestLogger::log("DealManager::pushDeal after store validation ", $order->store);
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
        RestLogger::log('DealManager::updateDeal begin');

        $this->dealDao->updateDealStatus($deal);

        RestLogger::log('DealManager::updateDeal end');
    }

    public function addDealShare($share)
    {
        RestLogger::log('DealManager::addDealShare begin');
        $this->shareManager->addDealShare($share);

        $share->deal->status = LeaderDeal::$STATUS_SHARED;
        $this->updateDeal($share->deal);
        RestLogger::log('DealManager::addDealShare end');
    }

    public function shareDeal($share)
    {
        $share->status = Share::$SHARE_STATUS_PENDING;

        $this->fillShareOrderParams($share);

        $this->addDealShare($share);

        $share->target = new ShareTarget(ShareTarget::$SHARE_TARGET_FRIEND);
        if ($this->shareToFriends($share))
        {
            $share->status = Share::$SHARE_STATUS_SHARED;
            $this->updateDealShare($share);

            $share->target = new ShareTarget(ShareTarget::$SHARE_TARGET_LEADER_ON_SHARE);
            $this->shareToLeader($share);

            return true;
        }
        else
        {
            $share->status = Share::$SHARE_STATUS_PENDING;
            return false;
        }
    }

    public function fillDealShare($share)
    {
        try
        {
            $share->status = Share::$SHARE_STATUS_PENDING;
            $this->addDealShare($share);
            $this->shareManager->fillShare($share);

            RestLogger::log('DealManager::fillDealShare after', $share);
        } catch (Exception $e)
        {
            RestLogger::log($e->getMessage());
        }
    }

    public function updateDealShare($share)
    {
        RestLogger::log('DealManager::updateDealShare begin');
        $this->shareManager->updateDealShare($share);

        if ($share->isShared())
        {
            $share->deal->status = LeaderDeal::$STATUS_SHARED;
            $this->updateDeal($share->deal);
        }
        RestLogger::log('DealManager::updateDealShare end');
    }

    private function fillShareOrderParams($share)
    {
        $deal = $this->getDealById($share->deal->id);
        $orderParams = $this->storeManager->queryStoreAdapter($share->store, 'orderdetails');

        $orderAdapter = new JsonOrderAdapter();
        $deal->order = $orderAdapter->fromArray(json_decode($orderParams, true));

        $this->storeManager->validateBranch($deal->order->store, $deal->order->branch);

        RestLogger::log('DealManager::fillShareOrderParams order', $deal->order);

        $share->deal = $deal;
    }

    private function shareToFriends($share)
    {
        return $this->shareManager->share($share);
    }

    private function shareToLeader($share)
    {
        RestLogger::log('DealManager::shareToLeader begin');
        $from = $share->sendFrom;
        $to = $share->sendTo;

        $share->sendTo = array($share->sendFrom);
        $share->sendFrom = new Customer($share->deal->order->branch->email);

        RestLogger::log('branch is', $share->deal->order->branch);

        $result = $this->shareManager->share($share);

        $share->sendTo = $to;
        $share->sendFrom = $from;

        RestLogger::log('DealManager::shareToLeader end', $result);
        return $result;
    }
}

