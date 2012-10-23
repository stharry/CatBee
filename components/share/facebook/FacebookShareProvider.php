<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/model/components/IShareProvider.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/3dParty/facebook/facebook.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/ShareNode.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/ShareContext.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/ShareAuthorization.php");
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/components/rest/RestLogger.php");

class FacebookShareProvider implements IShareProvider
{

    private $apiKey;
    private $apiSecret;
    private $authDao;

    //todo: must be saved in the db
    private static $provider_Id = 2;

    private function loadCredentials()
    {
        $this->apiKey = '369374193139831';
        $this->apiSecret = '894b434b7da7bca8c5549e6e5584581f';
    }

    private function getAuthorization($customer)
    {
        $shareNode = new ShareNode();
        $shareNode->leader = $customer;
        $shareNode->context = new ShareContext();
        $shareNode->context->id = FacebookShareProvider::$provider_Id;

        RestLogger::log("FacebookShareProvider::getAuthorization Before get auth");

        $authorization = $this->authDao->getAuthorization($shareNode);

        return $authorization;
    }

    function __construct($authDao)
    {
        $this->authDao = $authDao;

        $this->loadCredentials();
    }

    public function share($share)
    {
//        http://www.facebook.com/dialog/send?app_id=123050457758183&
//name=People%20Argue%20Just%20to%20Win&
//        link=http://www.nytimes.com/2011/06/15/arts/people-argue-just-to-win-scholars-assert.html&
//redirect_uri=http://www.example.com/response
        // TODO: Implement share() method.
    }

    public function getContacts($customer)
    {
        RestLogger::log("FacebookShareProvider::getContacts start");

        $authorization = $this->getAuthorization($customer);

//        $fql_query_url = 'https://graph.facebook.com/'
//            . '/fql?q=SELECT+uid2+FROM+friend+WHERE+uid1=me()'
//            . '&access_token=' . $authorization->accessToken;
//
//        RestLogger::log("FacebookShareProvider::getContacts goto facebook ".$fql_query_url);
//
//        $fql_query_result = file_get_contents($fql_query_url);
//        $facebookFriends = json_decode($fql_query_result, true);
//
//        RestLogger::log("FacebookShareProvider::getContacts after facebook ".$fql_query_result);
//
//        $fcbUrl = 'https://graph.facebook.com/me/friends?limit=0&fields=id,name&access_token='.$authorization->accessToken;
//        RestLogger::log("FacebookShareProvider::getContacts goto facebook ".$fcbUrl);
//
//        $fcbResult = file_get_contents($fcbUrl);
//        $facebookFriends = json_decode($fcbResult, true);
//        RestLogger::log("FacebookShareProvider::getContacts after facebook ".$fcbResult);


        ob_end_clean();

        $facebook = new Facebook(
            array('appId' => $this->apiKey,
                'secret' => $this->apiSecret,
                'cookie' => true));

        $facebook->setAccessToken($authorization->accessToken);

        $facebookFriends = $facebook->api('/me/friends/');

        if ($facebookFriends)
        {
            RestLogger::log("FacebookShareProvider::getContacts: ", $facebookFriends);
        }
        else
        {
            RestLogger::log("FacebookShareProvider::getContacts: Nothing");
        }

        $friends = array();

        foreach ($facebookFriends["data"] as $facebookFriend)
        {
            $friend = new Customer();
            $friend->email = '';
            $friend->firstName = $facebookFriend['name'];
            $friend->sharedUserId = $facebookFriend['id'];
            $friend->sharedPhoto = 'https://graph.facebook.com/'.$facebookFriend['id'].'/picture';

            array_push($friends, $friend);
        }

        return $friends;
    }

    public function requiresAuthentication($shareNode)
    {
        if ($this->getAuthorization($shareNode->leader))
        {
            return false;
        }
        return true;
    }

    public function getAuthenticationUrl($shareNode, $params)
    {
        $url = $GLOBALS["restURL"].'/CatBee/components/share/facebook/facebookLogin.php';

        RestLogger::log("FacebookShareProvider::getAuthenticationUrl ".$url);

        return $url;
    }
}
