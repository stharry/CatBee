<?php

include_once("/CatBee/scripts/global.php");

class DbManager
{
    private static $connection;

    private static function MakePersistConnection()
    {
        $dbHost = $GLOBALS["dbhost"];
        $dbName = $GLOBALS["dbname"];

        DbManager:: $connection = new PDO("mysql:host={$dbHost};dbname={$dbName}",
            $GLOBALS["dbusername"], $GLOBALS["dbpassword"],
            array( PDO::ATTR_PERSISTENT => true
        ));

        DbManager:: $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        DbManager:: $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    public static function getConnection()
    {
        if (DbManager::$connection == null) {
            DbManager::MakePersistConnection();
        }
        return DbManager::$connection;
    }

}
