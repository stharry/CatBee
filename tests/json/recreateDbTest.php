<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
//IncludeComponent('dao', 'DbManager');

$dropSql = explode(";", file_get_contents($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/sql/DropTables.sql"));
$createSql = explode(";", file_get_contents($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/sql/CreateTables.sql"));

try
{

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
    echo "Recreate DB - OK </p>";
} catch (Exception $e)
{
    echo "Failed: ".$e->getMessage()."</p>";
}