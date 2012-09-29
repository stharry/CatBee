<?php

include_once('../../components/rest/RestUtils.php');
include_once('../../components/campaign/CampaignManager.php');
include_once('../../components/campaign/DefaultCampaignStrategy.php');
include_once('../../components/landing/DefaultLeaderLandingStrategy.php');
include_once('../../components/dao/PDO/PdoStoreDao.php');
include_once('../../components/dao/PDO/PdoCustomerDao.php');
include_once('../../components/dao/PDO/PdoCampaignDao.php');
include_once('../../components/dao/PDO/PdoLeaderLandingDao.php');
include_once('../../components/dao/PDO/PdoLeaderLandingRewardDao.php');

$campaign = json_decode(file_get_contents("DemoCampaign.json"));

//var_dump($campaign);

//$restUtils = new RestUtils();
//$restUtils->SendPostRequest("campaign", "", $campaign);

$campaignManager = new CampaignManager(new PdoStoreDao(),
    new PdoCustomerDao(),
    new PdoCampaignDao(
        new PdoLeaderLandingDao(
            new PdoLeaderLandingRewardDao())),
    new DefaultCampaignStrategy(),
    new DefaultLeaderLandingStrategy());

$campaignManager->saveCampaign($campaign);

echo "THE END";