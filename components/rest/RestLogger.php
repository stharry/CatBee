<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
require_once 'Log.php';

class RestLogger
{
    public static function log($message, $params = null)
    {
        try
        {
            $conf = array('mode' => 0600, 'timeFormat' => '%X %x');
            $logger = & Log::singleton('file', $GLOBALS['restLogBaseDir'].'\CatBee.log', 'ident', $conf);

            if (!$params)
            {
                $logger->log($message);
            }
            else
            {
                $logger->log($message . ":" . json_encode($params));
            }
        }
        catch (Exception $e)
        {
            echo "Rest logger exception: " . $e->getMessage();
        }
    }


}
