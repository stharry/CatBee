<?php
class DealManager implements IDealManager
{
    private $campaignManager;
    private $storeManager;
    private $shareManager;
    private $dealDao;
    private $successfulReferralManager;

    function __construct(
        $campaignManager, $storeManager,
        $shareManager, $dealDao,
        $successfulReferralManager)
    {
        RestLogger::log("Deal manager before created...");
        try
        {
            $this->campaignManager           = $campaignManager;
            $this->dealDao                   = $dealDao;
            $this->storeManager              = $storeManager;
            $this->shareManager              = $shareManager;
            $this->successfulReferralManager = $successfulReferralManager;

            RestLogger::log("Deal manager created...");
        } catch (Exception $e)
        {
            RestLogger::log('EXCEPTION ', $e);
        }
    }

    private function createShareContexts($deal)
    {
        $clientContexts = array('facebook' => 'fbcContext',
                                'twitter'  => 'twitContext');

        foreach ($clientContexts as $ctxKey => $ctxProp)
        {
            $shareContext      = new ShareContext($ctxKey);
            $shareContext->uid = uniqid("", true);

            $this->shareManager->fillShareContext($deal, $shareContext);

            $deal->$ctxProp = $shareContext;
        }
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
        catbeeLayoutComp($layout, "twittForm", $leaderDeal);
        //catbeeLayoutComp($layout, "sliderOptions", $leaderDeal);
        catbeeLayout($layout, 'landing');

    }

    private function refreshDealProps($leaderDeal, $landing, $order)
    {
        $leaderDeal->sharePoint = $this->getCatBeeSharePoint();
        $leaderDeal->landing    = $landing;
        $leaderDeal->order      = $order;
    }

    private function createPendingDeal($landing, $order, $campaign)
    {
        try
        {
            RestLogger::log("DealManager:createPendingDeal begin", $this->dealDao);
            //ToDo - Tomer:I think this is not necessary... what are the chances the deal on that specific order exists already?
            //Instead of this we can catch and Exception when trying to insert the same Deal Twice and handle it
            //This is a small issues but can affect performance a little
            $leaderDeal = $this->dealDao->getDealByOrder($order);

            if (!$leaderDeal)
            {
                RestLogger::log("DealManager::createPendingDeal new Deal adding");

                $leaderDeal = new LeaderDeal();

                $leaderDeal->customer = $order->customer;
                if ($order->date != null) $leaderDeal->InitDate = $order->date;
                else $leaderDeal->InitDate = date("Y-m-d h:i:s");
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
        $this->storeManager->validateBranch($order->branch);
        //Register SucessfulReferral Deal If Exist
        RestLogger::log("DealManager::pushDeal after storeBranch validation ", $order->branch);

        $this->successfulReferralManager->saveSucessfulReferral($order);

        $campaign = $this->campaignManager->chooseCampaign($order);

        RestLogger::log("DealManager::pushDeal after campaign choosing ", $campaign);

        $leaderLanding = $this->campaignManager->chooseLeaderLanding($campaign, $order);
        RestLogger::log("DealManager::pushDeal after landing choosing ", $leaderLanding);

        $leaderDeal = $this->createPendingDeal($leaderLanding, $order, $campaign);

        $this->createShareContexts($leaderDeal);

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

    public function getDeals($dealFilter)
    {
        //Go to DealDao with the DealFilter and Retrieve all the deals of the Customer
        $leaderDeals = $this->dealDao->getDealsByFilter($dealFilter);
        if ($dealFilter->ActiveShareFlag == true)
        {
            //Fill the ActiveShares Of the Deals - currenlty assuming i have only one deal per customer
            //Call the shareManager - send him the Deal object, the Second parameter is a flag for getting the leads for each Active share
            $this->shareManager->FillActiveSharesForDeal($leaderDeals, true);
        }

        return $leaderDeals;
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

        $this->fillShareParams($share);

        if ($this->shareManager->share($share))
        {
            $share->status = Share::$SHARE_STATUS_SHARED;
            $this->addDealShare($share);

            return true;
        }
        else
        {
            return false;
        }
    }

    public function fillDealShare($share)
    {
        try
        {
            $this->fillShareParams($share);

            $share->target = new ShareTarget(ShareTarget::$SHARE_TARGET_FRIEND);
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

    private function fillShareParams($share)
    {
        if (!$share->deal->campaign->id)
        {
            $campaignFilter       = new CampaignFilter();
            $campaignFilter->code = $share->deal->campaign->code;

            $campaigns             = $this->campaignManager->getCampaigns($campaignFilter);
            $share->deal->campaign = $campaigns[ 0 ];

            RestLogger::log('DealManager::FillParams campaign by code', $share->deal->campaign);
        }

        if (!$share->context->uid)
        {
            $share->context->uid = uniqid("", true);
        }
        $this->storeManager->validateBranch($share->deal->order->branch);
    }

    private function shareToFriends($share)
    {
        return $this->shareManager->share($share);
    }
}
