<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
require_once 'Log.php';

class RestLogger
{
    private static $logger;

    public static function log($message, $params = null)
    {
        try
        {
            if (!RestLogger::$logger)
            {
                $conf = array('mode' => 0600, 'timeFormat' => '%X %x');
                RestLogger::$logger = & Log::singleton('file', $GLOBALS['restLogBaseDir'].'\CatBee.log', 'ident', $conf);
            }
            if (!$params)
            {
                RestLogger::$logger->log($message);
            }
            else
            {
                RestLogger::$logger->log($message . ":" . json_encode($params));
            }
        }
        catch (Exception $e)
        {
            echo "Rest logger exception: " . $e->getMessage();
        }
    }


}
