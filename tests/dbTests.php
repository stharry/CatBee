<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/CatBee/scripts/globals.php";
include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/model/Order.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/model/Customer.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/model/Store.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/model/LandingDeal.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/components/dao/ICustomerDao.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/components/dao/PDO/PdoCustomerDao.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/components/dao/PDO/PdoCustomerDao.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/components/campaign/CampaignManager.php");

$campaignManager = new CampaignManager();

$order = new Order();

$order->customer = new Customer();
$order->customer->email = "kuku@shmuku.com";
$order->customer->firstName = "Kuku";
$order->customer->lastName = "Shmuku";

$order->store = new Store();


$campaignManager->pushCampaign($order);