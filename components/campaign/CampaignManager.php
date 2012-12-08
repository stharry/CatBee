<?php


class CampaignManager implements ICampaignManager
{
    private $storeDao;
    private $customerDao;
    private $campaignDao;
    private $friendLandingDao;
    private $campaignStrategy;
    private $landingStrategy;
    private $friendLandingStrategy;
    private $restrictionsManager;

    function __construct($storeDao, $customerDao, $campaignDao,
                         $friendLandingDao,
                         $campaignStrategy, $landingStrategy,
                         $friendLandingStrategy,
                         $restrictionsManager)
    {
        $this->storeDao = $storeDao;
        $this->customerDao = $customerDao;
        $this->campaignDao = $campaignDao;
        $this->friendLandingDao = $friendLandingDao;

        $this->campaignStrategy = $campaignStrategy;
        $this->landingStrategy = $landingStrategy;
        $this->friendLandingStrategy = $friendLandingStrategy;
        $this->restrictionsManager = $restrictionsManager;
    }

    private function checkCustomer($customer)
    {
        if (!$this->customerDao->IsCustomerExists($customer))
        {
            $this->customerDao->InsertCustomer($customer);
        }
        return true;
    }

    private function checkStore($store)
    {
        if (!$this->storeDao->isStoreExists($store))
        {
            $this->storeDao->insertStore($store);
        }
        return true;
    }

    private function validateOrder($order)
    {
        if (!$this->checkCustomer($order->customer)) die("Unknown customer");

        if (!$this->checkStore($order->store)) die ("Unknown store");

    }

    private function getValidCampaigns($branch)
    {
        $campaignFilter = new CampaignFilter();
        $campaignFilter->store = new Store();
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

        if (isset($campaignFilter->store) && isset($campaignFilter->store->authCode))
        {
            if (!$this->storeDao->isStoreExists($campaignFilter->store))
            {
                return null;
            }
        }

        $campaigns = $this->campaignDao->getCampaigns($campaignFilter);

        foreach ($campaigns as $campaign)
        {
            $campaign->restrictions = $this->restrictionsManager->getRestrictions($campaign);
        }

        RestLogger::log('CampaignManager::getCampaigns end');

        return $campaigns;
    }

    public function saveCampaign($campaign)
    {
        $this->checkStore($campaign->store);
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
}
