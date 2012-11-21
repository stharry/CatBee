<?php

try
{
    echo "DOCUMENT_ROOT: ".$_SERVER["DOCUMENT_ROOT"]." \n";
    echo "SERVER_NAME: ".$_SERVER["SERVER_NAME"]." \n";

    include_once('recreateDbTest.php');
    include_once('registerStoreBranches.php');
    include_once('addFacebookShareApplication.php');
    include_once('pushCampaign.php');
    include_once('addStoreEmailShareTemplate.php');
    include_once('addStoreFacebookShareTemplate.php');

    include_once('pushDeal.php');
    include_once('shareStoreShareTemplate.php');
    include_once('friendDeal.php');
    include_once('pushReferredDeal.php');
}
catch (Exception $e)
{
    echo "Failed: " . $e->getMessage();
}