<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

//var_dump($GLOBALS);

echo $GLOBALS['catBeeParams']['Rest_url'];

echo CatBeeExpressions::validateString("{Rest_url}\/CatBee\/adapters\/demo\/api\/");

echo "Hello world";
echo "1";
echo $_SERVER['DOCUMENT_ROOT'];
echo "Goodbye world";