<?php
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
include ('../../components/adapters/json/JsonFriendLandingAdapter.php');

$restRequest = RestUtils::processRequest() or die("Campaign format is wrong");
$action = $restRequest->getCatBeeAction();
$context = $restRequest->getCatBeeContext();

RestLogger::log("Deal API $action context is ", $context);

$campaignManager = new CampaignManager(
    new PdoStoreDao(),
    new PdoCustomerDao(),
    new PdoCampaignDao(
        new PdoLeaderLandingDao(
            new PdoLeaderLandingRewardDao()),new PdoFriendLandingDao()),
    new PdoFriendLandingDao(),
    new DefaultCampaignStrategy(),
    new DefaultLeaderLandingStrategy(),
    new DefaultFriendLandingStrategy());


$dealManager = new DealManager($campaignManager,
    new StoreManager(new PdoStoreDao(), new PdoStoreBranchDao()),
    new ShareManager(new PdoStoreDao(), new PdoShareDao(),
        new PdoCustomerDao(), new PdoShareApplicationDao(),
        new PdoDealShareDao(),
        new HtmlPageAdapter()),
    new PdoDealDao());

$friendLandingManager = new FriendLandingManager(
    new PdoDealDao(),
    new PdoFriendLandingDao(),
    new PdoCustomerDao(),
    new PdoRewardDao(),
    new PdoCampaignDao(new PdoLeaderLandingDao(
    new PdoLeaderLandingRewardDao()),new PdoFriendLandingDao()),
    new StoreManager(new PdoStoreDao(),new PdoStoreBranchDao()));

switch (strtolower($action))
{

    case "deal":

        RestLogger::log("Deal API before deal");
        $orderAdapter = new JsonOrderAdapter();
        $order = $orderAdapter->fromArray($context);

        RestLogger::log("Deal API order is ", $order);

        $deal = $dealManager->pushDeal($order);
//       $jsonDealAdapter = new JsonDealAdapter();
//        $dealProps = $jsonDealAdapter->toArray($deal);
//
//        RestLogger::log("Deal API after deal");
//       // RestUtils::sendResponse(0, $dealProps);
        exit;

    case "frienddeal":
        $friendDealAdapter = new JsonFriendDealAdapter();
        $friendDeal = $friendDealAdapter->fromArray($context);
        $friendLandingManager->startSharedDeal($friendDeal);
        exit;

    case "sharedeal":
        $shareAdapter = new JsonShareAdapter();
        $share = $shareAdapter->fromArray($context);
        $dealManager->shareDeal($share);
        break;

    case "addshare":
        $shareAdapter = new JsonShareAdapter();
        $share = $shareAdapter->fromArray($context);
        $dealManager->addDealShare($share);
        break;

}



