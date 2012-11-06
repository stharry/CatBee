<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

RestLogger::log("Share api call started");

$return_obj = RestUtils::processRequest() or die ("Cannot parse post data in share request");

$action = $return_obj->getCatBeeAction();
$context = $return_obj->getCatBeeContext();

RestLogger::log("Share api {$action} request vars: ", $context);

$shareManager = new ShareManager(
    new PdoStoreDao(), new PdoShareDao(),
    new PdoCustomerDao(), new PdoShareApplicationDao(),
    new HtmlPageAdapter());

switch ($action)
{
    case "set":
        $shareTemplateAdapter = new JsonShareTemplateAdapter();
        $shareTemplate = $shareTemplateAdapter->fromArray($context);

        $shareManager->setShareTemplate($shareTemplate);

        RestUtils::sendSuccessResponse();
        exit();

    case "get":
        $shareFilterAdapter = new JsonShareFilterAdapter();
        $shareFilter = $shareFilterAdapter->fromArray($context);

        $shareTemplates = $shareManager->getShareTemplates($shareFilter);

        $shareTemplateAdapter = new JsonShareTemplateAdapter();
        $ShareTemplatesProps = $shareTemplateAdapter->toArray($shareTemplates);

        RestUtils::sendSuccessResponse($ShareTemplatesProps);
        exit();

    case "share":
        $jsonShareAdapter = new JsonShareAdapter();
        $share = $jsonShareAdapter->fromArray($context);

        $status = $shareManager->share($share);

        $response = array("status" => $status);
        RestUtils::sendSuccessResponse($response);
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
            $url .= '?api=share&params=' .urlencode(json_encode($return_obj->getRequestVars()));

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

            RestUtils::sendSuccessResponse($response);
            exit();
        }

    case "fillshare":

        $jsonShareAdapter = new JsonShareAdapter();
        $share = $jsonShareAdapter->fromArray($context);

        RestLogger::log("share api:fillshare start ", $share);

        $shareManager->fillShare($share);

        $shareProps = $jsonShareAdapter->toArray($share);

        RestLogger::log("share api:fillshare response ", $shareProps);

        RestUtils::sendSuccessResponse($shareProps);
        exit();

    case "getsharedcustomer":

        $contextAdapter = new JsonShareContextAdapter();
        $shareContext = $contextAdapter->fromArray($context);

        $customer = $shareManager->getCurrentSharedCustomer($shareContext);

        if ($customer)
        {
            $customerAdapter = new JsonCustomerAdapter();
            $customerProps = $customerAdapter->toArray($customer);
            RestUtils::sendSuccessResponse($customerProps);
        }
        else
        {
            RestUtils::sendFailedResponse('There is no connected user');
        }
        exit;

    case "setapplication":
        $contextAdapter = new JsonShareContextAdapter();
        $shareContext = $contextAdapter->fromArray($context);

        RestLogger::log("share api:setapplication before ", $shareContext);

        $shareManager->addShareApplication($shareContext);

        RestLogger::log("share api:setapplication after ");

        RestUtils::sendSuccessResponse();
        exit();

}
