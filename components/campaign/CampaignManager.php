<?php


class CampaignManager implements ICampaignManager
{
    private $storeBranchDao;
    private $customerDao;
    private $campaignDao;
    private $friendLandingDao;
    private $campaignStrategy;
    private $landingStrategy;
    private $friendLandingStrategy;
    private $restrictionsManager;

    function __construct($customerDao, $campaignDao,
                         $friendLandingDao,
                         $campaignStrategy, $landingStrategy,
                         $friendLandingStrategy,
                         $restrictionsManager,$storeBranchDao)
    {
        $this->customerDao = $customerDao;
        $this->campaignDao = $campaignDao;
        $this->friendLandingDao = $friendLandingDao;

        $this->campaignStrategy = $campaignStrategy;
        $this->landingStrategy = $landingStrategy;
        $this->friendLandingStrategy = $friendLandingStrategy;
        $this->restrictionsManager = $restrictionsManager;
        $this->storeBranchDao = $storeBranchDao;

        RestLogger::log("Campaign manager created...");
    }

    private function checkCustomer($customer)
    {
        if (!$this->customerDao->IsCustomerExists($customer))
        {
            $this->customerDao->InsertCustomer($customer);
        }
        return true;
    }

    private function checkStoreBranch($store)
    {
        if($store && !$store->id && !$this->storeBranchDao->isStoreBranchExists($store))
        {
            die('Store does not exists');

        }
        return true;
    }

    private function validateOrder($order)
    {
        if (!$this->checkCustomer($order->customer)) die("Unknown customer");
    }

    private function getValidCampaigns($branch)
    {
        $campaignFilter = new CampaignFilter();
        $campaignFilter->store = new Adaptor();
        $campaignFilter->store->id = $branch->id;
        return $this->getCampaigns($campaignFilter);
    }

    private function chooseCompatibleCampaign($campaigns, $order)
    {
        return $this->campaignStrategy->chooseCampaign($campaigns, $order);
    }

    public function chooseCampaign($order)
    {

        $this->validateOrder($order);
        $campaigns = $this->getValidCampaigns($order->branch);

        return $this->chooseCompatibleCampaign($campaigns, $order);
    }

    public function getCampaigns($campaignFilter)
    {
        RestLogger::log('CampaignManager::getCampaigns begin');

        $this->checkStoreBranch($campaignFilter->store);

        $campaigns = $this->campaignDao->getCampaigns($campaignFilter);

        foreach ($campaigns as $campaign)
        {
            $campaign->restrictions = $this->restrictionsManager->getRestrictions($campaign);

            $this->storeBranchDao->loadBranchById($campaign->store);
        }

        RestLogger::log('CampaignManager::getCampaigns end');

        return $campaigns;
    }

    public function saveCampaign($campaign)
    {
        $this->checkStoreBranch($campaign->store);

        if ($campaign->landingUrl)
        {
            $campaign->landingUrl = CatBeeExpressions::validateString($campaign->landingUrl);
        }

        $this->campaignDao->insertCampaign($campaign);
        $this->friendLandingDao->insertFriendLandings($campaign);
        $this->restrictionsManager->saveRestrictions($campaign);

    }

    public function chooseLeaderLanding($campaign, $order)
    {
        return $this->landingStrategy->chooseLeaderLanding($campaign, $order);
    }

    public function chooseFriendLStrategy($campaign, $order)
    {
      return $this->friendLandingStrategy->chooseFriendLanding($campaign, $order);
    }

    public function getCampaignFriendLanding($campaign)
    {
        return $this->friendLandingDao->GetFriendLanding($campaign);
    }

    private function addDiscount(&$discounts, $reward)
    {
        if (!array_key_exists($reward->code, $discounts))
        {
            $discount = new CampaignDiscount();
            $discount->code = $reward->code;
            $discount->value = $reward->value;
            $discount->isAbsolute = $reward->typeDescription != '%' ? '1' : '0';
            $discount->useCount = 999999;

            $discounts[$reward->code] = $discount;
        }
    }

    public function getDiscounts($campaignFilter)
    {
        $campaigns = $this->getCampaigns($campaignFilter);

        $discounts = array();

        foreach ($campaigns as $campaign)
        {
            foreach ($campaign->landings as $landing)
            {
                foreach ($landing->landingRewards as $landingReward)
                {
                    $this->addDiscount($discounts, $landingReward->leaderReward);
                    $this->addDiscount($discounts, $landingReward->friendReward);
                }
            }
        }

        $result = array();

        foreach ($discounts as $code => $discount)
        {
            array_push($result, $discount);
        }

        RestLogger::log('getDiscounts', $result);
        return $result;
    }
}
