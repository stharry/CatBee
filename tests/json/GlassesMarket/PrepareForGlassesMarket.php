<?php
//includeTest('recreateDbTest.php');//Delete the GM Campaign... we can do it manually for now

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponent('rest', 'RestUtils');

$Store = json_decode(file_get_contents("RegisterGMStore.json"));

$restUtils = new RestUtils();
$restUtils->SendPostRequest("store", "", $Store);


$campaign = json_decode(file_get_contents("pushGMCampaign.json"));
$restUtils->SendPostRequest("campaign", "", $campaign);

//includeTest('addStoreShareTemplates.php');
//includeTest('pushDeal.php');
//includeTest('shareStoreShareTemplate.php');
//includeTest('friendDeal.php');
//includeTest('pushReferredDeal.php');


function includeTest($testName)
{
try
{
RestLogger::log('Test '.$testName.' Before');
echo "<p>".'Before '.$testName."<p>";

    include_once($testName);

    echo "<p>".$testName.' - OK'."<p>";
    RestLogger::log('Test '.$testName.' After');
    }
    catch (Exception $e)
    {
    echo "<p>".$testName." failed. Reason: " . $e->getMessage()."<p>";
    }
}