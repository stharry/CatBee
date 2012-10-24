<?php

try
{
    include_once('recreateDbTest.php');
    include_once('registerStoreBranches.php');
    include_once('pushCampaign.php');
    include_once('addStoreEmailShareTemplate.php');
    include_once('addStoreFacebookShareTemplate.php');
    include_once('pushDeal.php');
    include_once('friendDeal.php');

}
catch (Exception $e)
{
    echo "Failed: " . $e->getMessage();
}