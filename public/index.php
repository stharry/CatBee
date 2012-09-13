<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

include_once 'globals.php';
$GLOBALS["page_title"] = "Tomer";

catbeeLayoutComp($layout, "inputforms/form");
catbeeLayout($layout, 'default');

//catbeeLayoutComp($layout, "test/test", array("asi" => "lalala"));
//catbeeLayoutComp($layout, "test/test", array("asi" => "bababaab"));
//catbeeLayout($layout, 'default');
?>