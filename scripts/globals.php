<?php
error_reporting(E_ERROR);
//require_once "Mail.php";
$dirBase = $_SERVER['DOCUMENT_ROOT']."/CatBee";

$catBeeParams = parse_ini_file($dirBase."/COnfig/config.ini");

$dbhost = $catBeeParams["catbee_db_host"];
$dbusername = $catBeeParams["catbee_db_user"];
$dbpassword = $catBeeParams["catbee_db_pass"];
$dbname = $catBeeParams["catbee_db_name"];

$smtphost =$catBeeParams["catbee_email_hostname"];
$smtpport = $catBeeParams["catbee_email_hostport"];
$smtpuser = $catBeeParams["catbee_email_hostpass"];
$smtppass = $catBeeParams[""];

$rootPath = "/CatBee/public/";

function includeScript($name, &$p) {
	include $GLOBALS["dirBase"] . "/scripts/" . $name . ".php";
}

function includeModel($name) {
	include_once $GLOBALS["dirBase"] . "/scripts/models/" . $name . ".php";
}

function IncludeComponent($dir,$name){
    include_once $GLOBALS["dirBase"] . "/components/" . $dir . "/".$name.".php";
}

function catbeeComp($comp, &$p) {
	includeScript("comps/" . $comp, $p);
}

function catbeeLayoutComp(&$layout, $comp, $params) {
	if (gettype($layout) == "NULL")
		$layout = array();
	$layout[] = array("comp" => $comp, "params" => $params);
}

function catbeeRender($layout) {
	$ctr = 0;
	foreach ($layout as $ccomp) {
		catbeeComp($ccomp["comp"], $ccomp["params"]);
	}
}

function catbeeLayout($layout, $layoutfile) {
	includeScript("layouts/" . $layoutfile, $layout);
}

function dbConnect() {
   mysql_connect($GLOBALS["dbhost"], $GLOBALS["dbusername"], $GLOBALS["dbpassword"]) or die('Could not connect: ' . mysql_error());
    //mysql_connect() or die('Could not connect: ' . mysql_error());
	mysql_select_db($GLOBALS["dbname"]) or die('Could not select database');
}

dbConnect();
?>