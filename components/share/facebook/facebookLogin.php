<?php

//// based on:
//// https://developers.facebook.com/docs/howtos/login/server-side-login/
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
include3rdParty('facebook', 'facebook');

$facebook = new Facebook(array(
    'appId' => '369374193139831',
    'secret' => '894b434b7da7bca8c5549e6e5584581f',
    'cookie' => true
));

$restRequest = RestUtils::processRequest();
$params = $restRequest->getRequestVars();
RestLogger::log("facebookLogin:before get user. Get params:", $params);

if (!isset($params) || (count($params) == 0))
{
    RestLogger::log("FacebookLogin: no parameters - return stub success");
    include('facebookClose.php');
    //RestUtils::sendSuccessResponse();
    exit();
}
elseif (isset($params["success"]))
{
    RestLogger::log("FacebookLogin: success stub response - sent OK");
    exit();
}
elseif (isset($params["post_id"]))
{
    $dealId = $params['pdl'];

    $updateParams = array('action' => 'add share',
        'context' => array('sendTo' => $params['post_id'],
                            'deal' => array('id' => $dealId),
                            'context' => array('type' => 'facebook')));

    RestUtils::SendPostRequest('deal', null, $updateParams);
    RestLogger::log("FacebookLogin: success stub response on post_id - sent OK");
    include('facebookClose.php');
    exit();
}

$code = $params["code"];

$user = $facebook->getUser();
RestLogger::log("facebookLogin: used ID".$user);

if (!$code)
{
    $loginUrl = $facebook->getLoginUrl(
        array("scope" => 'email,offline_access,publish_stream,user_birthday,user_location,user_work_history,user_about_me,user_hometown',
            "redirect_uri" => $GLOBALS["restURL"].'/CatBee/components/share/facebook/facebookLogin.php?'
                . http_build_query($restRequest->getRequestVars()),
            'display' => 'popup'));

    RestLogger::log("facebook before Login: facebook login url: " . $loginUrl);

    //$facebook->makeRequest($loginUrl, '');

    //RestUtils::SendFreeUrlRequest($loginUrl, '');

//    b_start();
//    ob_end_flush();

    header('location: ' . $loginUrl);

    exit();


}
else
{
    RestLogger::log("facebookLogin: code exists: $code");

    $token_url = "https://graph.facebook.com/oauth/access_token?"
        . "client_id=" . $facebook->getAppId()
        . "&redirect_uri=" . urlencode($GLOBALS["restURL"].'/CatBee/components/share/facebook/facebookLogin.php')
        . "&client_secret=" . $facebook->getAppSecret() . "&code=" . $code;

    $response = file_get_contents($token_url);
    $params = null;
    parse_str($response, $params);
    $facebook->setAccessToken($params['access_token']);

    RestLogger::log("facebookLogin: after get access token: ".$facebook->getAccessToken());

//    $facebook->setExtendedAccessToken();

    $shareNodeAdapter = new JsonShareNodeAdapter();

    $params = (array)json_decode(urldecode($params[ "params" ]), true);

    $shareNodeProps = $params["context"];

    $shareNode = $shareNodeAdapter->fromArray($shareNodeProps);

    RestLogger::log("facebookLogin: share node is ", $shareNode);

    $customerDao = new PdoCustomerDao();
    if (!$customerDao->isCustomerExists($shareNode->leader))
    {
        !$customerDao->insertCustomer($shareNode->leader);
    }

    $shareAuthorization = new ShareAuthorization();
    $shareAuthorization->accessToken = $facebook->getAccessToken();
    $shareAuthorization->userId = $facebook->getUser();

    $authCustomersDao = new PdoAuthorizationDao();
    $authCustomersDao->setAuthorization($shareNode, $shareAuthorization);

    $apiPath = $params[ 'api' ];

    $apiUrl = $GLOBALS["restURL"].'/CatBee/api/'.$apiPath
        .'/?'.http_build_query($params);

    RestLogger::log("facebookLogin:before redirect to api: ".$apiUrl);

    header('location: '.$apiUrl);

    //RestUtils::SendGetRequest($restRequest->getRequestVars()[ $apiPath ], '', $apiParams);

}