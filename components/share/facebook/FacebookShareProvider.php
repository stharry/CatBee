<?php

include3rdParty('facebook', 'facebook');

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
        RestLogger::log("FacebookShareProvider::share NOT IMPLEMENTED");
//
//        $parameters = array(
//            'app_id' => '369374193139831',
//            'link' => 'http://www.tribzi.com/',
//            'picture' => 'http://www.medfordmailboxshop.com/Merchant/Images_Product/Box/Wood/198-wood-train-L.jpg',
//            'name' => 'Hi, I shared a great deal for you...:)',
//            'caption' => 'TribZi Deal',
//            'display' => 'popup',
//            'redirect_uri' => $GLOBALS["restURL"].'/CatBee/components/share/facebook/facebookLogin.php'
//
//        );
//        $url = 'http://www.facebook.com/dialog/send?'.http_build_query($parameters);
//
//        echo "<script>blah = window.open('".$url."')</script>";
//
//        //echo("<script> top.location.href='" . $url . "'</script>");
//
//        RestLogger::log("FacebookShareProvider::share end ".$url);

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

    public function getCurrentSharedCustomer()
    {
        $facebook = new Facebook(
            array('appId' => $this->apiKey,
                'secret' => $this->apiSecret,
                'cookie' => true));

        $user = $facebook->getUser();
        if ($user)
        {
            $user_profile = $facebook->api('/me');

            $customer = new Customer();
            $customer->email = $user_profile["email"];
            $customer->firstName = $user_profile["first_name"];
            $customer->lastName = $user_profile["last_name"];
            $customer->sharedUserId = $user;

            return $customer;
        }
        return null;
    }
}
