<?php
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

$restRequest = RestUtils::processRequest() or die("Campaign format is wrong");
$action  = $restRequest->getCatBeeAction();
$context = $restRequest->getCatBeeContext();

RestLogger::log("tribe API: $action context is ", $context);
try
{

    switch (strtolower($action))
    {

        case "get":
            $tribeFilterAdapter = new JsonAdaptorTribeFilter();

            $tribeFilter = $tribeFilterAdapter->fromArray($context);
            $tribeManager = new TribeManager();
            $tribe = $tribeManager->GetTribe($tribeFilter);
            $tribeAdapter = new JsonTribeAdapter();
            RestUtils::sendSuccessResponse($tribeAdapter->toArray($tribe));
            exit;
        default:
            RestLogger::log('ERROR: action  not registered');
            exit;
    }
}
catch (Exception $e)
{
    echo $e->getMessage();
}