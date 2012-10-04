<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/rest/RestUtils.php");

foreach (glob($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/json/*.php") as $filename) include_once($filename);
foreach (glob($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/html/*.php") as $filename) include_once($filename);
foreach (glob($_SERVER['DOCUMENT_ROOT']."/CatBee/components/dao/PDO/*.php") as $filename) include_once($filename);

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/share/ShareManager.php");

//echo "-------";
//var_dump($_POST);
//echo "-------";

$return_obj = RestUtils::processRequest() or die ("Cannot parse post data in share request");
$shareProps = $return_obj->getRequestVars() or die("Unknown share format");

$action = $shareProps["action"];
$context = $shareProps["context"];

$shareManager = new ShareManager(
    new PdoStoreDao(), new PdoShareDao(), new HtmlPageAdapter());

switch ($action)
{
    case "set":
        $shareTemplateAdapter = new JsonShareTemplateAdapter();
        $shareTemplate = $shareTemplateAdapter->fromArray($context);

        $shareManager->setShareTemplate($shareTemplate);

        RestUtils::sendResponse(0, "OK");
        break;

    case "get":
        $shareFilterAdapter = new JsonShareFilterAdapter();
        $shareFilter = $shareFilterAdapter->fromArray($context);

        $shareTemplates = $shareManager->getShareTemplates($shareFilter);

        $shareTemplateAdapter = new JsonShareTemplateAdapter();
        $ShareTemplatesProps = $shareTemplateAdapter->toArray($shareTemplates);

        RestUtils::sendResponse(0, $ShareTemplatesProps);
        break;

    case "share":
        $jsonShareAdapter = new JsonShareAdapter();
        $share = $jsonShareAdapter->fromArray($context);

        $status = $shareManager->share($share);

        $response = array("status" => $status);
        RestUtils::sendResponse(0, $response);
        break;

}
