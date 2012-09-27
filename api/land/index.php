<?php

//hello from Tomer

include('../../components/rest/RestUtils.php');
include('../../components/campaign/CampaignManager.php');
include('../../components/adapters/json/JsonOrderAdapter.php');
include('../../components/adapters/json/JsonDealAdapter.php');

$orderProps = RestUtils::processRequest() or die("Basa");

$orderAdapter = new JsonOrderAdapter();
$order = $orderAdapter->fromArray($orderProps->getRequestVars());

$campaignManager = new CampaignManager();
$deal = $campaignManager->pushCampaign($order);

$jsonDealAdapter = new JsonDealAdapter();
$dealProps = $jsonDealAdapter->toArray($deal);

RestUtils::sendResponse(0, $dealProps);