<?php
error_reporting(E_ERROR);
//require_once "Mail.php";

require_once('CatBeeClassLoader.php');

$dirBase = $_SERVER['DOCUMENT_ROOT']."/CatBee";

$catBeeParams = parse_ini_file($dirBase."/COnfig/config.ini");

$dbhost = $catBeeParams["catbee_db_host"];
$dbusername = $catBeeParams["catbee_db_user"];
$dbpassword = $catBeeParams["catbee_db_pass"];
$dbname = $catBeeParams["catbee_db_name"];

$smtphost =$catBeeParams["catbee_email_hostname"];
$smtpport = $catBeeParams["catbee_email_hostport"];
$smtpuser = $catBeeParams["catbee_email_hostuser"];
$smtppass = $catBeeParams["catbee_email_hostpass"];

$rootPath = "/CatBee/public/";

$restURL = $catBeeParams["Rest_url"];

$loader = new CatBeeClassLoader($GLOBALS["dirBase"]);

spl_autoload_register('catBeeAutoLoader');

function catBeeAutoLoader($class)
{
    global $loader;
    $loader->registerClass($class);
}

function includeScript($name, &$p) {
	include $GLOBALS["dirBase"] . "/scripts/" . $name . ".php";
}

function includeModel($name) {
    global $loader;
    $loader->registerModel($name);
	//include_once $GLOBALS["dirBase"] . "/model/" . $name . ".php";
}

function includeLogger()
{
    IncludeComponent('rest', 'RestLogger');
}

function includeDbManager()
{
    IncludeComponent('dao', 'DbManager');
}

function IncludeComponent($dir,$name){
    include_once $GLOBALS["dirBase"] . "/components/" . $dir . "/".$name.".php";
}

function IncludeComponents($dir) {
    foreach (glob($_SERVER['DOCUMENT_ROOT']."/CatBee/components/". $dir. "/*.php") as $filename) {
        include_once($filename);
    }
}

function include3rdParty($dir, $name)
{
    include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/3dParty/". $dir . "/".$name.".php");

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