<?php

echo json_encode($_SERVER);
exit;
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

$className = 'Json'.'Order'.'Adapter';
$adapter = new $className();