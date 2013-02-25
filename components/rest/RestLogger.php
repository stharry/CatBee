<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
require_once 'Log.php';

class RestLogger
{
    private static $logger;
    //test
    private static function setLogger()
    {
        if (!RestLogger::$logger)
        {
            $conf = array('mode' => 0600, 'timeFormat' => '%H:%M:%S');
            RestLogger::$logger = & Log::singleton('file', $GLOBALS['restLogBaseDir'].'/CatBee.log', 'ident', $conf);
        }
    }

    public static function log($message, $params = null)
    {

        try
        {
            RestLogger::setLogger();
            $x = microtime(true);
            $milliseconds = round(($x - intval($x)) * 1000);
            if (!$params)
            {
                RestLogger::$logger->log($milliseconds.' '.$message);
            }
            else
            {
                RestLogger::$logger->log($milliseconds.' '.$message . ":" . json_encode($params));
            }
        }
        catch (Exception $e)
        {
            echo "Rest logger exception: " . $e->getMessage();
        }
    }


}
