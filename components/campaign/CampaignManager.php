<?php

include_once $_SERVER['DOCUMENT_ROOT']."/CatBee/scripts/globals.php";
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/Order.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/LandingDeal.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/dao/ICustomerDao.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/dao/PDO/PdoCustomerDao.php");

class CampaignManager
{
    private function GetCustomerDao()
    {
        return new PdoCustomerDao();
    }
    private function checkCustomer($customer)
    {
        $customerDao = $this->GetCustomerDao();

        if (!$customerDao->IsCustomerExists($customer))
        {
            $customerDao->InsertCustomer($customer);
        }
        return true;
    }

    private function checkStore($store)
    {
        true;

    }

    private function validateOrder($order)
    {
        if (!$this->checkCustomer($order->customer)) return false;

        if (!$this->checkStore($order->store)) return false;

        return true;
    }

    private  function  getLeaderLanding($order)
    {
        return true;
    }

    private function createPendingDeal($landing)
    {
        $leaderDeal = new LeaderDeal();

        return $leaderDeal;
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

        $temp1 = new sliderPhrase('a','b');
        $sliderPhrase= $temp1->getSliderPhrase('DefCamp');

        $temp2 = new leaderReward('1','b','a','d',10);
        $leaderReward= $temp2->getleaderReward('DefCamp');

        $GLOBALS["page_title"] = "CatBee Landing Page";
        $GLOBALS["title"] = $slogan->firstLine;
        $GLOBALS["subtitle"] = $slogan->secondLine;

        catbeeLayoutComp($layout, "inputforms/landing",$sliderPhrase);

        catbeeLayout($layout, 'landing');

    }

    public function pushCampaign($order)
    {
        //$this->validateOrder($order) or die ("customer is not valid");

        //$landing = $this->getLeaderLanding($order) or die("Cannot get landing page for given store");

        //$leaderDeal = $this->createPendingDeal($landing);

        $this->showLeaderDeal($leaderDeal);
    }

}
