<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

$params = array('post_id' => 123, 'pdl' => 1);
RestUtils::SendComponentRequest('share/facebook/facebookLogin.php', null, $params);

echo 'OK';