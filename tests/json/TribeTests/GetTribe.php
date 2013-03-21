<?php
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponent('rest', 'RestUtils');
$restUtils = new RestUtils();

$insertSql = explode(";", file_get_contents($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/sql/InitTribeTesting.sql"));

foreach ($insertSql as $sql)
{
    if (trim($sql) != '')
    {
        DbManager::selectValues($sql);
    }
}
$filter = json_decode(file_get_contents("res/GetTribeByFilter.json"));
$tribe = json_decode($restUtils->SendPostRequestAndReturnResult("tribe", "", $filter), true);
var_export($tribe);


