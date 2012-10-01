<?php

//hello from Vadim

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/rest/RestUtils.php");

foreach (glob($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/json/*.php") as $filename) include_once($filename);
foreach (glob($_SERVER['DOCUMENT_ROOT']."/CatBee/components/dao/PDO/*.php") as $filename) include_once($filename);

IncludeComponent("campaign","CampaignManager");
IncludeComponent("deal","DealManager");
IncludeComponent("campaign","DefaultCampaignStrategy");
IncludeComponent("landing","DefaultLeaderLandingStrategy");

$campaignProps = RestUtils::processRequest()->getRequestVars() or die("Campaign format is wrong");
$action = $campaignProps["action"];
$context = $campaignProps["context"];

$campaignManager = new CampaignManager(new PdoStoreDao(),
    new PdoCustomerDao(),
    new PdoCampaignDao(
        new PdoLeaderLandingDao(
            new PdoLeaderLandingRewardDao())),
    new DefaultCampaignStrategy(),
    new DefaultLeaderLandingStrategy());


$dealManager = new DealManager($campaignManager, new PdoDealDao());
switch ($action)
{

    case "push":
        $orderAdapter = new JsonOrderAdapter();
        $order = $orderAdapter->fromArray($context);
        $deal = $dealManager->pushDeal($order);
        $jsonDealAdapter = new JsonDealAdapter();
        $dealProps = $jsonDealAdapter->toArray($deal);

        //RestUtils::sendResponse(0, $dealProps);
        break;


}



