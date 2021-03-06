<?php


include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponent('rest', 'RestUtils');

$restUtils = new RestUtils();

$Store = json_decode(file_get_contents("RegisterCTTStore.json"));
$restUtils->SendPostRequest("store", "", $Store);
echo "Store register - OK </p>";

$StoreCfg = json_decode(file_get_contents("CTTSetStoreBranchConfig.json"));
$restUtils->SendPostRequest("store", "", $StoreCfg);
echo "Store config - OK </p>";

$campaign = json_decode(file_get_contents("PushCTTCamp.json"));
$restUtils->SendPostRequest("campaign", "", $campaign);

$dir = $GLOBALS[ "dirBase" ] . '/tests/json/CTT/CTTadd*ShareTemp.json';

foreach (glob($dir) as $ff)
{
    echo $ff;
    $shareTemplate = json_decode(file_get_contents($ff));

    $restUtils = new RestUtils();
    $restUtils->SendPostRequest("share", "", $shareTemplate);

    echo "Add ".basename($ff)." - OK </p>";
}

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