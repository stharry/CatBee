<?php


include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

$requestObj = RestUtils::processRequest() or die("Store format is wrong");
$action = $requestObj->getCatBeeAction();
$context = $requestObj->getCatBeeContext();
RestLogger::log("Store API {$action} context is ", $context);

$storeManager = new StoreManager(new PdoAdaptorDao(),
                                 new PdoStoreBranchDao(),
                                 new PdoStoreBranchConfigDao());

switch ($action)
{
    case "register":
    {
        extractStoreBranches($context, $adaptor, $branches);

        $storeManager->registerAdaptor($adaptor);
        //Currenlty it will work only for one Branch in the array:
        $branches[0]->adaptor = $adaptor;

        $storeManager->registerBranches($branches);
        RestUtils::sendSuccessResponse();
        break;
    }

    case "unregister":
    {
        extractStoreBranches($context, $adaptor, $branches);

        $storeManager->unregisterBranches($adaptor, $branches);
        RestUtils::sendSuccessResponse();
        break;

    }

    case "getconfig":
    {
        RestLogger::log("get config started");

        $configFilter = new StoreBranchConfigFilter();
        $configFilter->shopId = $context['shopId'];
        $configFilter->widgetId = $context['widgetId'];

        $branchConfig = $storeManager->getBranchConfig($configFilter);

        $configAdapter = new JsonBranchConfigAdapter();
        $widgetProps = $configAdapter->toArray($branchConfig);

        RestLogger::log("get config response", $widgetProps);
        RestUtils::sendSuccessResponse($widgetProps);
        break;
    }

    case "setconfig":
    {
        $configAdapter = new JsonBranchConfigAdapter();
        $branchConfig = $configAdapter->fromArray($context);

        $storeManager->setBranchConfig($branchConfig);
        RestUtils::sendSuccessResponse();
    }
}

function extractStoreBranches($context, &$adaptor, &$branches)
{
    $adaptorAdapter = new JsonAdaptorAdapter();
    $adaptor = $adaptorAdapter->fromArray($context["store"]);

    $branchesAdapter = new JsonStoreBranchAdapter();
    $branches = $branchesAdapter->fromArray($context["branches"]);
}