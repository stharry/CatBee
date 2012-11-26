<?php
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

$dropSql = explode(";", file_get_contents($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/sql/DropTables.sql"));
$createSql = explode(";", file_get_contents($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/sql/CreateTables.sql"));

foreach ($dropSql as $sql)
{
    if (trim($sql) != '')
    {
        DbManager::selectValues($sql);
    }
}
foreach ($createSql as $sql)
{
    if (trim($sql) != '')
    {
        DbManager::selectValues($sql);
    }
}
