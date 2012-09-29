<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/scripts/globals.php");

class DbManager
{
    private static $connection;

    private static function buildInsertExpression($table, $names)
    {
        $expr = "INSERT INTO {$table} (".implode(",", $names).")  VALUES (:".implode(",:", $names).") ";

        return $expr;
    }

    private static function buildParameters($names, $params)
    {
        $paramsArray = array();

        for ($parNo = 0; $parNo < count($names); $parNo++)
        {
            $paramsArray[":".$names[$parNo]] = $params[$parNo];
        }

        return $paramsArray;
    }

    private  static function setValues($expression, $params = array())
    {
        try {
            $conn = DbManager::getConnection();

            $q = $conn->prepare($expression);
            $q->execute($params);

            return $conn;
        } catch (PDOException $pe) {
            echo $pe->getMessage();
        }
    }
    private static function MakePersistConnection()
    {
        $dbHost = $GLOBALS["dbhost"];
        $dbName = $GLOBALS["dbname"];

        DbManager:: $connection = new PDO("mysql:host={$dbHost};dbname={$dbName}",
            $GLOBALS["dbusername"], $GLOBALS["dbpassword"],
            array(PDO::ATTR_PERSISTENT => true
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

    public static function selectValues($selectExpression, $params = array())
    {
        $conn = DbManager::getConnection();
        $stmt = $conn->prepare($selectExpression);

        $paramNo = 1;
        foreach ($params as $key => $value) {
            $stmt->bindValue($paramNo, $key, $value);
            $paramNo++;
        }
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            //echo "</p> There is nothing to return in: ".$selectExpression;
            //var_dump($params);
            return null;
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function insertValues($insertExpression, $params = array())
    {
        DbManager::setValues($insertExpression, $params);
    }

    public static function insert($table, $fieldNames, $fieldValues)
    {
        $expr = DbManager::buildInsertExpression($table, $fieldNames);

        $params = DbManager::buildParameters($fieldNames, $fieldValues);

        //echo "</p> insert to <".$table."> as : ".$expr."</p>";
        //var_dump($params);

        return DbManager::setValues($expr,  $params);
    }

    public static function insertAndReturnId($table, $fieldNames, $fieldValues, $idColumnName="id")
    {
        try {
            $conn = DbManager::insert($table, $fieldNames, $fieldValues);

            //echo "</p>before get last id</p>";

            return $conn->lastInsertId($idColumnName);

        } catch (PDOException $pe) {
            echo $pe->getMessage();
        }

    }
    public static function updateValues($updateExpression, $params = array())
    {
        DbManager::setValues($updateExpression, $params);
    }

    public static function insertValuesAndReturnId($insertExpression, $params = array(), $idColumnName = "id")
    {
        try {
            $conn =  DbManager::insertValues($insertExpression, $params);
            return $conn->lastInsertId($idColumnName);
        } catch (PDOException $pe) {
            echo $pe->getMessage();
        }
    }

}
