<?php

class DbManager
{
    private static $connection;

    private static function buildInsertExpression($table, $names)
    {
        $expr = "INSERT INTO {$table} (" . implode(",", $names) . ")  VALUES (:" . implode(",:", $names) . ") ";

        return $expr;
    }

    private static function buildParameters($names, $params)
    {
        $paramsArray = array();

        for ($parNo = 0; $parNo < count($names); $parNo++)
        {
            $paramsArray[ ":" . $names[ $parNo ] ] = $params[ $parNo ];
        }

        return $paramsArray;
    }

    private static function setValues($expression, $params = array())
    {
        try
        {
            $conn = DbManager::getConnection();

            $q = $conn->prepare($expression);

            $q->execute($params);

            RestLogger::log('DbManager::setValues after insert');

            return $conn;
        } catch (PDOException $pe)
        {
            RestLogger::log('EXCEPTION ' . $pe->getMessage());
            RestLogger::log('EXCEPTION STACK ', $pe->getTrace());
        }
    }

    private static function MakePersistConnection()
    {
        $dbHost = $GLOBALS[ "dbhost" ];
        $dbName = $GLOBALS[ "dbname" ];

        try
        {
            DbManager:: $connection = new PDO("mysql:host={$dbHost};dbname={$dbName}",
                $GLOBALS[ "dbusername" ], $GLOBALS[ "dbpassword" ]
             //   , array(PDO::ATTR_PERSISTENT => true)
            );
        } catch (Exception $e)
        {
            mysql_close();
            RestLogger::log("Error opening connection ", $e);
            throw new Exception("Cannot connection to the data base");
        }


        DbManager:: $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        DbManager:: $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    public static function getConnection()
    {
        if (DbManager::$connection == null)
        {
            DbManager::MakePersistConnection();
        }
        return DbManager::$connection;
    }

    public static function selectValues($selectExpression, $params = array())
    {

        RestLogger::log("DbManager::selectValues SQL: " . $selectExpression, $params);

        try
        {
            $conn = DbManager::getConnection();
            $stmt = $conn->prepare($selectExpression);

            $paramNo = 1;

            foreach($params as $dbParam)
            {
                $stmt->bindValue($paramNo,$dbParam->paramValue,$dbParam->paramType);
                $paramNo++;
            }

            $stmt->execute();


            if ($stmt->rowCount() == 0)
            {
                //echo "</p> There is nothing to return in: ".$selectExpression;
                //var_dump($params);
                return null;
            }

            RestLogger::log("DbManager::selectValues row count: " . $stmt->rowCount());

            $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt = null;

            RestLogger::log("DbManager::selectValuesvalues are: ", $values);

            return $values;
        }
        catch (Exception $e)
        {
            RestLogger::log('DbManager::selectValues exception ', $e->getMessage());
            RestLogger::log('EXCEPTION STACK ', $e->getTrace());
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    public static function insertValues($insertExpression, $params = array())
    {
        return DbManager::setValues($insertExpression, $params);
    }

    public static function insertOnly($table, $fieldNames, $fieldValues)
    {
        try
        {
            $conn = DbManager::insert($table, $fieldNames, $fieldValues);

            $conn = null;
        }
        catch (Exception $e)
        {
            RestLogger::log('EXCEPTION: ', $e->getMessage());
            RestLogger::log('EXCEPTION STACK ', $e->getTrace());
        }
    }

    private static function insert($table, $fieldNames, $fieldValues)
    {
        try
        {
            $expr = DbManager::buildInsertExpression($table, $fieldNames);

            $params = DbManager::buildParameters($fieldNames, $fieldValues);

            RestLogger::log("DbManager::insert table: " . $table . " fields: ", $fieldNames);
            RestLogger::log("DbManager::insert table: " . $table . " values: ", $fieldValues);

            $conn = DbManager::setValues($expr, $params);

            return $conn;

        }
        catch (Exception $e)
        {
            RestLogger::log('EXCEPTION: ', $e->getMessage());
            RestLogger::log('EXCEPTION STACK ', $e->getTrace());
            return null;
        }
    }

    public static function insertAndReturnId($table, $fieldNames, $fieldValues, $idColumnName = "id")
    {
        try
        {
            $conn = DbManager::insert($table, $fieldNames, $fieldValues);
            $id = $conn->lastInsertId($idColumnName);

            RestLogger::log('DbManager::insertAndReturnId id ', $id);

            $conn = null;

            return $id;

        } catch (PDOException $pe)
        {
            RestLogger::log('DbManager::insertAndReturnId exception ', $pe->getMessage());
            RestLogger::log('EXCEPTION STACK ', $pe->getTrace());
            return null;
        }

    }

    public static function updateValues($updateExpression, $params = array())
    {
        DbManager::setValues($updateExpression, $params);

        RestLogger::log('DbManager::updateValues ok for ' . $updateExpression, $params);
    }

    public static function insertValuesAndReturnId($insertExpression, $params = array(), $idColumnName = "id")
    {
        try
        {
            $conn = DbManager::insertValues($insertExpression, $params);

            $id = $conn->lastInsertId($idColumnName);

            $conn = null;

            return $id;

        } catch (PDOException $pe)
        {
            RestLogger::log('DbManager::insertValuesAndReturnId exception ', $pe->getMessage());
            RestLogger::log('EXCEPTION STACK ', $pe->getTrace());
        }
    }

}
