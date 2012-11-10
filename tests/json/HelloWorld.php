<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

echo urldecode("http%3A%2F%2Ffolica.tellapal.com%2Fa%2Fclk%2F1QZCtT	");

exit;
//var_dump($GLOBALS);

echo $GLOBALS['catBeeParams']['Rest_url'];

echo CatBeeExpressions::validateString("{Rest_url}\/CatBee\/adapters\/demo\/api\/");


echo "Hello world";
echo "1";
echo $_SERVER['DOCUMENT_ROOT'];
echo "Goodbye world";