<?php
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

$restRequest = RestUtils::processRequest()->getRequestVars() or die("cannot proceed action");

switch ($restRequest['act'])
{
    case 'get':
    {
//        $action = apc_fetch($restRequest['shop']);
//        echo $action ? $action : 'not set';
//        exit;
//        $memobj = memcache_connect('localhost', 11211);
//        $action = memcache_get($memobj, $restRequest['shop']);
//
//        if ($action)
//        {
//            echo $action;
//        }
//        else
//        {
//            echo '';
//        }
        $shopId = $restRequest['shop'];
        $rows = DbManager::selectValues('SELECT action a from ShopActions WHERE shopId = '.$shopId, null);

        echo $rows[0]['a'];
        exit;
    }

    case 'set':
    {
//        $memobj = memcache_connect('localhost', 11211);
//
//        memcache_set($memobj, $restRequest['shop'], $restRequest['a']);
        $sql = "UPDATE ShopActions SET action=:action WHERE shopId=:shopId";

        $params = array(
            ':action' => $restRequest['a'],
            ':shopId' => $restRequest['shop']);

        DbManager::updateValues($sql, $params);
        exit;
    }
}

