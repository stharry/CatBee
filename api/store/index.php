<?php


include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

$requestObj = RestUtils::processRequest() or die("Campaign format is wrong");
$action = $requestObj->getCatBeeAction();
$context = $requestObj->getCatBeeContext();
RestLogger::log("Store API $action context is ", $context);

$adaptorAdapter = new JsonAdaptorAdapter();
$adaptor = $adaptorAdapter->fromArray($context["store"]);

$branchesAdapter = new JsonStoreBranchAdapter();
$branches = $branchesAdapter->fromArray($context["branches"]);

$storeManager = new StoreManager(new PdoAdaptorDao(), new PdoStoreBranchDao());

switch ($action)
{
    case "register":
    {
        $storeManager->registerAdaptor($adaptor);
        //Currenlty it will work only for one Branch in the array:
        $branches[0]->adaptor = $adaptor;

        $storeManager->registerBranches($branches);
        RestUtils::sendSuccessResponse();
    }

    case "unregister":
    {
        $storeManager->unregisterBranches($adaptor, $branches);
        RestUtils::sendSuccessResponse();

    }
}