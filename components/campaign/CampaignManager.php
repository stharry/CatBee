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
        if(!$this->storeBranchDao->isStoreBranchExists($store))
        {
            $this->storeBranchDao->addStoreBranch($store);

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
        $this ->checkStoreBranch($campaign->store);
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
