<?php
error_reporting(E_ERROR);
//require_once "Mail.php";
$dirBase = "C:/Program Files (x86)/EasyPHP-5.3.9/www/CatBee";
$dbhost = "localhost";
$dbusername = "root";
$dbpassword = "tomer165";
$dbname = "test";
$smtphost ="localhost";
$smtpport = 25;
$rootPath = "/CatBee/public/";

function includeScript($name, &$p) {
	include $GLOBALS["dirBase"] . "/scripts/" . $name . ".php";
}

function includeModel($name) {
	include_once $GLOBALS["dirBase"] . "/scripts/models/" . $name . ".php";
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
	mysql_select_db($GLOBALS["dbname"]) or die('Could not select database');
}

dbConnect();
?>