<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/components/rest/RestUtils.php");
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/components/rest/RestLogger.php");
include_once('../components/CatBeeFacade.php');

RestLogger::log("Share api call started");

$return_obj = RestUtils::processRequest() or die ("Cannot parse post data in share request");
$shareProps = $return_obj->getRequestVars() or die("Unknown share format");

if (!isset($shareProps['act'])) die("Undefined adapter action");

$facade = new CatBeeFacade();

switch (strtolower($shareProps['act']))
{
    case 'welcome':
    {
        $deal = $facade->GetCatBeeDealByNo($shareProps['pdl']);

        $currentCustomer = $facade->GetCatBeeLoggedinCustomer($shareProps['shr']);

        //???
    }
}