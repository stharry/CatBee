<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponents('rest');

RestLogger::log("Share api call started");

$return_obj = RestUtils::processRequest() or die ("Cannot parse post data in share request");
$shareProps = $return_obj->getRequestVars() or die("Unknown share format");

if (!isset($shareProps['act'])) die("Undefined adapter action");

switch (strtolower($shareProps['act']))
{
    case 'welcome':
    {

        $url = $GLOBALS['Rest_url'].'/CatBee/adapters/demo/Home.php?'
            .http_build_query(array(
                'page'=>'goWelcome.php',
                'sid' => $shareProps['sid']));

        RestLogger::log("demo adapter api url: ", $url);

        echo("<script> top.location.href='" . $url . "'</script>");
        exit;
    }
    case "orderdetails":
    {
        $dealProps = json_decode(file_get_contents($GLOBALS['Rest_url'].'/CatBee/adapters/demo/res/demoDeal.json'));
        $orderProps = $dealProps['context'];

        RestUtils::sendSuccessResponse($orderProps);
        exit;
    }
}