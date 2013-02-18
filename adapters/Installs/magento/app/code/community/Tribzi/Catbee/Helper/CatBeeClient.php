<?php
//
//if (!function_exists('curl_init'))
//{
//    throw new Exception('CatBee client needs the CURL PHP extension.');
//}
//if (!function_exists('json_decode'))
//{
//    throw new Exception('CatBee client needs the JSON PHP extension.');
//}

class CatBeeClient
{
    private $shop;
    private $adapter;
    private $server;

    private static $campaignAPI = 'campaign';

    function __construct()
    {
        $this->server = 'http://api.tribzi.com';
    }

    public function setServer($newServer)
    {
        $this->server = $newServer;

        return $this;
    }

    public function setShop($shop, $adapter)
    {
        $this->shop    = $shop;
        $this->adapter = $adapter;

        return $this;
    }

    public function api($api, $action, $context)
    {
        $url = $this->server . "/CatBee/api/{$api}/";

        $obj = array('action'  => $action,
                     'context' => $context);

        $postData = http_build_query($obj);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    public function getCampaigns()
    {
        return $this->api(CatBeeClient::$campaignAPI, 'get', array('shopId' => $this->shop));
    }

    public function getDiscounts($campaignCode)
    {
        return $this->api(CatBeeClient::$campaignAPI, 'get coupons',
                          array('shopId' => $this->shop,
                                'code'   => $campaignCode));
    }


}
