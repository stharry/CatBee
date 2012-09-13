<?php
include_once '../globals.php';
$GLOBALS["page_title"] = "Tomer";

catbeeLayoutComp($layout, "inputforms/landing",$_POST);
catbeeLayout($layout, 'default');

//catbeeLayoutComp($layout, "test/test", array("asi" => "lalala"));
//catbeeLayoutComp($layout, "test/test", array("asi" => "bababaab"));
//catbeeLayout($layout, 'default');
?>