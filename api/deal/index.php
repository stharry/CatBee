<?php
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

$restRequest = RestUtils::processRequest() or die("Campaign format is wrong");
$action  = $restRequest->getCatBeeAction();
$context = $restRequest->getCatBeeContext();

RestLogger::log("Deal API $action context is ", $context);

try
{

    $campaignDao     = new PdoCampaignDao(
        new PdoLeaderLandingDao(
            new PdoLeaderLandingRewardDao()),
        new PdoFriendLandingDao());

    $restrictionManager = new RestrictionsManager(
        new RestrictionValidatorFactory(),
        new PdoCampaignRestrictionsDao());

    $campaignManager = new CampaignManager(
        new PdoCustomerDao(),
        $campaignDao,
        new PdoFriendLandingDao(),
        new DefaultCampaignStrategy(),
        new DefaultLeaderLandingStrategy(),
        new DefaultFriendLandingStrategy(),
        $restrictionManager,
        new PdoStoreBranchDao());

    $storeManager    = new StoreManager(
        new PdoAdaptorDao(), new PdoStoreBranchDao());
    $customerManager = new CustomerManager(new PdoCustomerDao());

    $shareManager = new ShareManager(new PdoStoreBranchDao(), new PdoShareDao(),
        $customerManager,
        new PdoShareApplicationDao(),
        new PdoDealShareDao(),
        new PdoLeaderLandingRewardDao(),
        $campaignDao,
        new HtmlPageAdapter());

    $referralManager = new SuccessfulReferralManager(
        new PdoSuccessfulReferralDao());

    $dealDao = new PdoDealDao();

    $dealManager = new DealManager(
        $campaignManager,
        $storeManager,
        $shareManager,
        $dealDao,
        $referralManager);

    $friendLandingManager = new FriendLandingManager(
        new PdoDealDao(),
        new PdoFriendLandingDao(),
        new PdoCustomerDao(),
        new PdoLeaderLandingRewardDao(),
        $campaignManager,
        new PdoDealShareDao(),
        $storeManager,
        new ImpressionManager(new PdoImpression()));

    $discountManager = new DiscountManager(
        $restrictionManager,
        new PdoLeaderLandingRewardDao(),
        new PdoDealShareDao());

    switch (strtolower($action))
    {

        case "deal":
            RestLogger::log("Deal API before deal");
            $orderAdapter = new JsonOrderAdapter();
            $order        = $orderAdapter->fromArray($context);
            $deal = $dealManager->pushDeal($order);
            exit;

        case "frienddeal":
            $friendDealAdapter = new JsonFriendDealAdapter();
            $friendDeal        = $friendDealAdapter->fromArray($context);
            $friendLandingManager->startSharedDeal($friendDeal);
            exit;

        case "sharedeal":
            $shareAdapter = new JsonShareAdapter();
            $share        = $shareAdapter->fromArray($context);
            $dealManager->shareDeal($share);
            RestUtils::sendSuccessResponse($response);
            exit;

        case "addshare":
            $shareAdapter = new JsonShareAdapter();
            $share        = $shareAdapter->fromArray($context);
            $dealManager->addDealShare($share);
            RestUtils::sendSuccessResponse();
            exit;

        case "fillshare":
            $jsonShareAdapter = new JsonShareAdapter();
            $share            = $jsonShareAdapter->fromArray($context);
            $dealManager->fillDealShare($share);
            $shareProps = $jsonShareAdapter->toArray($share);
            RestLogger::log('deal api fillshare response is ', $shareProps);
            RestUtils::sendSuccessResponse($shareProps);
            exit();

        case "updateshare":
            $shareAdapter = new JsonShareAdapter();
            $share        = $shareAdapter->fromArray($context);
            $dealManager->addDealShare($share);
            RestUtils::sendSuccessResponse();
            exit;

        case "getdeal":
            $dealFilterAdapter = new JsonLeaderDealFilterAdapter();
            $dealFilter        = $dealFilterAdapter->fromArray($context);
            RestLogger::log('deal api dealFilter is ', $dealFilter);
            //Currently Hard Coded true
            $deals = $dealManager->getDeals($dealFilter);
            $dealsAdapter = new JsonLeaderDealsAdapter();
            RestUtils::sendSuccessResponse($dealsAdapter->toArray($deals));
            exit;

        case "getdiscount":
            RestLogger::log("Deal API before deal");
            $orderAdapter = new JsonOrderAdapter();
            $order        = $orderAdapter->fromArray($context);
            RestLogger::log("Deal API order is ", $order);
            $discountManager->applyDiscount($order);

            $orderProps = $orderAdapter->toArray($order);
            RestUtils::sendSuccessResponse($orderProps);

            exit;

        default:
            RestLogger::log('ERROR: action does not registered');
            exit;

    }
} catch (Exception $e)
{
    echo $e->getMessage();
}
