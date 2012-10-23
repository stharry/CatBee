<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/components/rest/RestUtils.php");
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/components/rest/RestLogger.php");

foreach (glob($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/components/adapters/json/*.php") as $filename) include_once($filename);
foreach (glob($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/components/adapters/html/*.php") as $filename) include_once($filename);
foreach (glob($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/components/dao/PDO/*.php") as $filename) include_once($filename);

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/components/share/ShareManager.php");


RestLogger::log("Share api call started");


$return_obj = RestUtils::processRequest() or die ("Cannot parse post data in share request");
$shareProps = $return_obj->getRequestVars() or die("Unknown share format");

$action = $return_obj->getCatBeeAction();
$context = $shareProps[ "context" ];

RestLogger::log("Share api request vars: ", $shareProps);

$shareManager = new ShareManager(
    new PdoStoreDao(), new PdoShareDao(),
    new PdoCustomerDao(), new HtmlPageAdapter());

switch ($action)
{
    case "set":
        $shareTemplateAdapter = new JsonShareTemplateAdapter();
        $shareTemplate = $shareTemplateAdapter->fromArray($context);

        $shareManager->setShareTemplate($shareTemplate);

        RestUtils::sendResponse(0, "OK");
        exit();

    case "get":
        $shareFilterAdapter = new JsonShareFilterAdapter();
        $shareFilter = $shareFilterAdapter->fromArray($context);

        $shareTemplates = $shareManager->getShareTemplates($shareFilter);

        $shareTemplateAdapter = new JsonShareTemplateAdapter();
        $ShareTemplatesProps = $shareTemplateAdapter->toArray($shareTemplates);

        RestUtils::sendResponse(0, $ShareTemplatesProps);
        exit();

    case "share":
        $jsonShareAdapter = new JsonShareAdapter();
        $share = $jsonShareAdapter->fromArray($context);

        $status = $shareManager->share($share);

        $response = array("status" => $status);
        RestUtils::sendResponse(0, $response);
        exit();

    case "getcontacts":

        RestLogger::log("share api:getcontacts start");

        $shareNodeAdapter = new JsonShareNodeAdapter();
        $shareNode = $shareNodeAdapter->fromArray($context);

        $needToAuthenticate = $shareManager->requiresAuthentication($shareNode);

        RestLogger::log("share api needToAuthenticate is ".$needToAuthenticate);

        if ($needToAuthenticate)
        {
            $url = $shareManager->getAuthenticationUrl($shareNode, null);
            $url .= '?api=share&params=' .urlencode(json_encode($shareProps));

            RestLogger::log(" Authorization url: " . $url);

            ob_end_clean();
            session_start();

            echo("<script> top.location.href='" . $url . "'</script>");
            exit();
        }
        else
        {
            RestLogger::log("share api:get contacts authorized");

            $shareManager->getContacts($shareNode);

            $response = $shareNodeAdapter->toArray($shareNode);

            RestLogger::log("share api:get contacts, send back", $response);

            RestUtils::sendResponse(0, $response);
            exit();
        }

    case "fillshare":

        $jsonShareAdapter = new JsonShareAdapter();
        $share = $jsonShareAdapter->fromArray($context);

        RestLogger::log("share api:getshare start ", $share);

        $shareManager->fillShare($share);

        $shareProps = $jsonShareAdapter->toArray($share);

        RestUtils::sendResponse(0, $shareProps);
        exit();

}
