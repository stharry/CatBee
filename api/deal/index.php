<?php

//hello from Vadim

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/rest/RestUtils.php");

foreach (glob($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/json/*.php") as $filename) include_once($filename);
foreach (glob($_SERVER['DOCUMENT_ROOT']."/CatBee/components/dao/PDO/*.php") as $filename) include_once($filename);

IncludeComponent("campaign","CampaignManager");
IncludeComponent("deal","DealManager");
IncludeComponent("FriendLanding","FriendLandingManager");
IncludeComponent("campaign","DefaultCampaignStrategy");
IncludeComponent("landing","DefaultLeaderLandingStrategy");
IncludeComponent("FriendLanding","friendLandingManager");

$campaignProps = RestUtils::processRequest()->getRequestVars() or die("Campaign format is wrong");
$action = $campaignProps["action"];
$context = $campaignProps["context"];

$campaignManager = new CampaignManager(new PdoStoreDao(),
    new PdoCustomerDao(),
    new PdoCampaignDao(
        new PdoLeaderLandingDao(
            new PdoLeaderLandingRewardDao()),new pdoFriendLAndingDao()),
    new DefaultCampaignStrategy(),
    new DefaultLeaderLandingStrategy()
    ,new friendLandingManager()
);

$dealManager = new DealManager($campaignManager, new PdoDealDao());
switch (strtolower($action))
{

    case "deal":
        $orderAdapter = new JsonOrderAdapter();
        $order = $orderAdapter->fromArray($context);
        $deal = $dealManager->pushDeal($order);
        $jsonDealAdapter = new JsonDealAdapter();
        $dealProps = $jsonDealAdapter->toArray($deal);

        //RestUtils::sendResponse(0, $dealProps);
        break;
        //TODO - ASk Vadim What did he mean By FreindDeal?
    case "frienddeal":
        echo json_encode($context);
        break;


}



