<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/rest/RestUtils.php");

foreach (glob($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/json/*.php") as $filename) include_once($filename);
foreach (glob($_SERVER['DOCUMENT_ROOT']."/CatBee/components/dao/PDO/*.php") as $filename) include_once($filename);

IncludeComponent("campaign","CampaignManager");
IncludeComponent("deal","DealManager");
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
            new PdoLeaderLandingRewardDao())),
    new DefaultCampaignStrategy(),
    new DefaultLeaderLandingStrategy()
   ,new friendLandingManager()
);

switch ($action)
{
    case "get":
        $campaignFilterAdapter = new JsonCampaignFilterAdapter();
        $campaignFilter = $campaignFilterAdapter->fromArray($context);

        $campaigns = $campaignManager->getCampaigns($campaignFilter);
        $campaignAdapter = new JsonCampaignAdapter();

        $campaignsProps = $campaignAdapter->toArray($campaigns);

        RestUtils::sendResponse(0, $campaignsProps);

        break;

    case "push":
        $campaignAdapter = new JsonCampaignAdapter();
        $campaign = $campaignAdapter->fromArray($context);
        $campaignManager->saveCampaign($campaign);

        RestUtils::sendResponse(0, "OK");
        break;

}
