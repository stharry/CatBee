<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

$orderAction = json_decode(file_get_contents("res/pushDeal.json"), true);
$orderAdapter = new JsonOrderAdapter();
$order = $orderAdapter->fromArray($orderAction['context']);

$storeDao = new PdoAdaptorDao();
$storeDao->loadStore($order->store);

$deal = new LeaderDeal();
$deal->order = $order;

$share = new Share();
$share->deal = $deal;

$share->sendFrom = new Customer();
$share->sendFrom->email = 'Leader@tribzi.com';
$share->sendFrom->firstName = 'Leader';

$share->sendTo = new Customer();
$share->sendTo->email = 'Friend@tribzi.com';
$share->sendTo->firstName = 'Friend';

$share->link = 'http://www.Tribzi.com';
$share->store = $order->store;

$campaignAction = json_decode(file_get_contents("res/pushCampaign.json"), true);
$campaignAdapter = new JsonCampaignAdapter();
$campaign = $campaignAdapter->fromArray($campaignAction['context']);

$share->campaign = $campaign;
$share->reward = $campaign->landings[0]->landingRewards[0];

$templateAction = json_decode(file_get_contents("res/addTribziLeaderShareTemplate.json"), true);
$templateAdapter = new JsonTemplateAdapter();

$template = $templateAdapter->fromArray($templateAction['context']['templatePage']['context']);
$builder = new TemplateBuilder();

echo "--------Leader email-----";
echo $builder->buildTemplate($share, $template, new HtmlTemplateDecorator());

$templateAction = json_decode(file_get_contents("res/addTribziShareTemplate.json"), true);
$template = $templateAdapter->fromArray($templateAction['context']['templatePage']['context']);

echo "--------Friend email-----";
echo $builder->buildTemplate($share, $template, new HtmlTemplateDecorator());
