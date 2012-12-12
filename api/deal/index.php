<?php
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

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
    new DefaultFriendLandingStrategy(),
    new RestrictionsManager(
        new RestrictionValidatorFactory(),
        new PdoCampaignRestrictionsDao()));


$dealManager = new DealManager($campaignManager,
    new StoreManager(new PdoStoreDao(), new PdoStoreBranchDao()),
    new ShareManager(new PdoStoreDao(), new PdoShareDao(),
        new CustomerManager(new PdoCustomerDao()),
        new PdoShareApplicationDao(),
        new PdoDealShareDao(),
        new PdoLeaderLandingRewardDao(),
        new HtmlPageAdapter()),
    new PdoDealDao(),
    new LeadManager(new PdoLeadDao()));

$friendLandingManager = new FriendLandingManager(
    new PdoDealDao(),
    new PdoFriendLandingDao(),
    new PdoCustomerDao(),
    new PdoLeaderLandingRewardDao(),
    new PdoCampaignDao(new PdoLeaderLandingDao(
        new PdoLeaderLandingRewardDao()),
        new PdoFriendLandingDao()),
    new PdoDealShareDao(),
    new StoreManager(new PdoStoreDao(),new PdoStoreBranchDao()));

$discountManager = new DiscountManager(
    new RestrictionsManager(
        new RestrictionValidatorFactory(),
        new PdoCampaignRestrictionsDao()),
    new PdoLeaderLandingRewardDao(),
    new PdoDealShareDao());

switch (strtolower($action))
{

    case "deal":
        RestLogger::log("Deal API before deal");
        $orderAdapter = new JsonOrderAdapter();
        $order = $orderAdapter->fromArray($context);
        RestLogger::log("Deal API order is ", $order);
        $deal = $dealManager->pushDeal($order);
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
        RestUtils::sendSuccessResponse($response);
        exit;

    case "addshare":
        $shareAdapter = new JsonShareAdapter();
        $share = $shareAdapter->fromArray($context);
        $dealManager->addDealShare($share);
        exit;

    case "fillshare":
        $jsonShareAdapter = new JsonShareAdapter();
        $share = $jsonShareAdapter->fromArray($context);
        $dealManager->fillDealShare($share);
        $shareProps = $jsonShareAdapter->toArray($share);
        RestLogger::log('deal api fillshare response is ', $shareProps);
        RestUtils::sendSuccessResponse($shareProps);
        exit();

    case "updateshare":
        $shareAdapter = new JsonShareAdapter();
        $share = $shareAdapter->fromArray($context);
        $dealManager->addDealShare($share);
        exit;

    case "getdeal":
        $dealFilter = new LeaderDealFilter();
        //TODO - Change The Adaptor to be the Leader Filter instead of the Customer
        $customerAdaptor = new JsonCustomerAdapter();
        $customer = $customerAdaptor->fromArray($context);
        $dealFilter->customer = $customer;
        //Currently Hard Coded true
        $dealFilter->ActiveShareFlag = true;
        //Currently the Get will echo the result at the End...
        $dealManager->getDeals($dealFilter);
        exit;

    case "getdiscount":
        RestLogger::log("Deal API before deal");
        $orderAdapter = new JsonOrderAdapter();
        $order = $orderAdapter->fromArray($context);
        RestLogger::log("Deal API order is ", $order);
        $discountManager->applyDiscount($order);

        $orderProps = $orderAdapter->toArray($order);
        RestUtils::sendSuccessResponse($orderProps);

        exit;

}