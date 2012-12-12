<?php


include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

$requestObj = RestUtils::processRequest() or die("Campaign format is wrong");
$action = $requestObj->getCatBeeAction();
$context = $requestObj->getCatBeeContext();
var_dump($action);
RestLogger::log("Store API $action context is ", $context);

$storeAdapter = new JsonStoreAdapter();
$store = $storeAdapter->fromArray($context["store"]);

$branchesAdapter = new JsonStoreBranchAdapter();
$branches = $branchesAdapter->fromArray($context["branches"]);

$storeManager = new StoreManager(new PdoStoreDao(), new PdoStoreBranchDao());

switch ($action)
{
    case "register":
    {

        $storeManager->registerBranches($store, $branches);
        RestUtils::sendSuccessResponse();
    }

    case "unregister":
    {
        $storeManager->unregisterBranches($store, $branches);
        RestUtils::sendSuccessResponse();

    }
}