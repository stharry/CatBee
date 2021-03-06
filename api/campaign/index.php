<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

$requestObj = RestUtils::processRequest() or die("Campaign format is wrong");
$action = $requestObj->getCatBeeAction();
$context = $requestObj->getCatBeeContext();

$campaignManager = new CampaignManager(
    new PdoCustomerDao(),
    new PdoCampaignDao(
        new PdoLeaderLandingDao(
            new PdoLeaderLandingRewardDao()),new PdoFriendLandingDao()),
    new PdoFriendLandingDao(),
    new DefaultCampaignStrategy(),
    new DefaultLeaderLandingStrategy(),
    new DefaultFriendLandingStrategy(),
    new RestrictionsManager(
        new RestrictionValidatorFactory(),
        new PdoCampaignRestrictionsDao()), new PdoStoreBranchDao()
);

switch (strtolower($action))
{
    case "get":
        $campaignFilterAdapter = new JsonCampaignFilterAdapter();
        $campaignFilter = $campaignFilterAdapter->fromArray($context);

        $campaigns = $campaignManager->getCampaigns($campaignFilter);
        $campaignAdapter = new JsonCampaignAdapter();

        $campaignsProps = $campaignAdapter->toArray($campaigns);

        RestUtils::sendResponse(200, $campaignsProps);

        break;

    case "push":
        $campaignAdapter = new JsonCampaignAdapter();
        $campaign = $campaignAdapter->fromArray($context);
        $campaignManager->saveCampaign($campaign);

        RestUtils::sendResponse(0, "OK");
        break;

    case 'getcoupons':
    {
        $campaignFilterAdapter = new JsonCampaignFilterAdapter();
        $campaignFilter = $campaignFilterAdapter->fromArray($context);

        $discounts = $campaignManager->getDiscounts($campaignFilter);
        $discountsAdapter = new JsonCampaignDiscountAdapter();

        $discountsProps = $discountsAdapter->toArray($discounts);

        RestUtils::sendResponse(200, $discountsProps);

        break;
    }

}
