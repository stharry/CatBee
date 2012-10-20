<?php

require_once 'Log.php';

class RestLogger
{
    public static function log($message, $params = null)
    {
        $conf = array('mode' => 0600, 'timeFormat' => '%X %x');
        $logger = &Log::singleton('file', 'c:\CatBee.log', 'ident', $conf);

        if (!$params)
        {
            $logger->log($message);
        }
        else
        {
            $logger->log($message.":".http_build_query($params));
        }
    }


}
