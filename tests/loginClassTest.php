

<?php
require $_SERVER['DOCUMENT_ROOT'] . '/CatBee/3dParty/facebook/facebook.php';

///* EDIT EMAIL AND PASSWORD */
//$EMAIL = "vad.chebyshev@retalix.com";
//$PASSWORD = "";

function cURL($url, $header=NULL, $cookie=NULL, $p=NULL)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, $header);
    curl_setopt($ch, CURLOPT_NOBODY, $header);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    if ($p) {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $p);
    }
    $result = curl_exec($ch);
    if ($result) {
        return $result;
    } else {
        return curl_error($ch);
    }
    curl_close($ch);
}
    echo "</p>---post--------------------</p> ";
    var_dump($_POST);
    echo "get ";
    var_dump($_GET);
    echo "server ";
    var_dump($_SERVER);
    //echo "session ";
    //var_dump($_SESSION);

$facebook = new Facebook(array(
    'appId' => '369374193139831',
    'secret' => '894b434b7da7bca8c5549e6e5584581f'
));
    $loginUrl = $facebook->getLoginUrl(
        array("scope" => "email,offline_access,publish_stream,user_birthday,user_location,user_work_history,user_about_me,user_hometown",
            "redirect_uri" => $GLOBALS["restURL"]."/CatBee/tests/facebookTest.php",
            'display' => 'popup'));

$res = cURL($loginUrl);

echo $res;
//$a = cURL("https://login.facebook.com/login.php?login_attempt=1",true,null,"email=$EMAIL&pass=$PASSWORD");
//preg_match('%Set-Cookie: ([^;]+);%',$a,$b);
//$c = cURL("https://login.facebook.com/login.php?login_attempt=1",true,$b[1],"email=$EMAIL&pass=$PASSWORD");
//preg_match_all('%Set-Cookie: ([^;]+);%',$c,$d);
//for($i=0;$i<count($d[0]);$i++)
//    $cookie.=$d[1][$i].";";
///*
//NOW TO JUST OPEN ANOTHER URL EDIT THE FIRST ARGUMENT OF THE FOLLOWING FUNCTION.
//TO SEND SOME DATA EDIT THE LAST ARGUMENT.
//*/
//echo cURL("http://www.facebook.com/",null,$cookie,null);
?>

