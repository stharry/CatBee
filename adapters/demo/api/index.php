<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponents('rest');

RestLogger::log("Demo adapter api call started");

$return_obj = RestUtils::processRequest() or die ("Cannot parse post data in share request");
$shareProps = $return_obj->getRequestVars() or die("Unknown share format");

//todo
//if (!isset($shareProps['act'])) die("Undefined adapter action");

switch (strtolower($shareProps['act']))
{

    case "orderdetails":
    {
        RestLogger::log('Demo adapter orderdetails api call started');

        $fileName = '../res/demoDeal.json';
        RestLogger::log('Demo adapter sample json', $fileName);

        $dealProps = json_decode(file_get_contents($fileName), true);
        RestLogger::log('Demo adapter orderdetails api call deal props', $dealProps);

        $orderProps = $dealProps['context'];

        RestLogger::log('Demo adapter orderdetails api call response', $orderProps);

        //echo json_encode($orderProps);
        RestUtils::sendSuccessResponse($orderProps);
        exit;
    }
    default:
    {

        $url = $GLOBALS['Rest_url'].'/CatBee/adapters/demo/Home.php?'
            .http_build_query(array(
                                  'page'=>'goWelcome.php',
                                  'sid' => $shareProps['sid']));

        RestLogger::log("demo adapter api url: ", $url);

        echo("<script> top.location.href='" . $url . "'</script>");
        exit;
    }
}