<?php

include_once $_SERVER['DOCUMENT_ROOT']."/CatBee/scripts/globals.php";
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/Order.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/LandingDeal.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/components/ICampaignManager.php");

class CampaignManager implements ICampaignManager
{
    private $storeDao;
    private $customerDao;
    private $campaignDao;
    private $campaignStrategy;
    private $landingStrategy;

    function __construct($storeDao, $customerDao, $campaignDao,
                         $campaignStrategy, $landingStrategy)
    {
        $this->storeDao = $storeDao;
        $this->customerDao = $customerDao;
        $this->campaignDao = $campaignDao;
        $this->campaignStrategy = $campaignStrategy;
        $this->landingStrategy = $landingStrategy;

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

    private function getValidCampaigns($store)
    {
        $campaignFilter = new CampaignFilter();
        $campaignFilter->storeCode = $store->authCode;

        return $this->getCampaigns($campaignFilter);
    }

    private function chooseCompatibleCampaign($campaigns, $order)
    {
        return $this->campaignStrategy->chooseCampaign($campaigns, $order);
    }

    public function chooseCampaign($order)
    {
        //echo "</p>choose campaign";

        $this->validateOrder($order);

        $campaigns = $this->getValidCampaigns($order->store);

        return $this->chooseCompatibleCampaign($campaigns, $order);
    }

    public function getCampaigns($campaignFilter)
    {
        return $this->campaignDao->getCampaigns($campaignFilter);
    }

    public function saveCampaign($campaign)
    {
        $this->checkStore($campaign->store);

        $this->campaignDao->insertCampaign($campaign);
    }

    public function chooseLeaderLanding($campaign, $order)
    {
        return $this->landingStrategy->chooseLeaderLanding($campaign, $order);
    }
}
