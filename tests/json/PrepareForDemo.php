<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

    echo "DOCUMENT_ROOT: ".$_SERVER["DOCUMENT_ROOT"]." \n";
    echo "SERVER_NAME: ".$_SERVER["SERVER_NAME"]." \n";

includeTest('recreateDbTest.php');
includeTest('registerStoreBranches.php');
includeTest('addFacebookShareApplication.php');
includeTest('pushCampaign.php');
includeTest('addStoreShareTemplates.php');
includeTest('pushDeal.php');
includeTest('shareStoreShareTemplate.php');
includeTest('friendDeal.php');
includeTest('pushReferredDeal.php');


function includeTest($testName)
{
    try
    {
        echo "<p>".'Before '.$testName."<p>";

        include_once($testName);

        echo "<p>".$testName.' - OK'."<p>";
    }
    catch (Exception $e)
    {
        echo "<p>".$testName." failed. Reason: " . $e->getMessage()."<p>";
    }
}