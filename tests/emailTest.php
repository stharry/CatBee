<?php

$a = "amount=15.0000&id=18&customer%5Bemail%5D=spidernah%40gmail.com&customer%5BfirstName%5D=spider+nah&branch%5BshopId%5D=1&branch%5Bstore%5D%5BauthCode%5D=19FB6C0C-3943-44D0-A40F-3DC401CB3703";
echo urldecode($a);

$b = json_decode(urldecode($a), true);
var_dump($b);
exit;
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
require_once "Mail.php";
require_once "Mail/mime.php";

$text = 'This is a message I sent from <a href="http://www.php.net/">PHP</a> '
    . 'using the PEAR Mail package and SMTP through Gmail. Enjoy!';
$subject = 'Sent from PHP on my machine';

$from = 'spidernah <spidernah@gmail.com>';
$to = 'vadim <vadim@tribzi.com>,spidernah <spidernah@gmail.com>, vad <vadim.chebyshev@retalix.com>';


$provider = new EmailShareProvider();

$share = new Share();
$share->sendFrom = $from;
$share->sendTo = $to;
$share->message = $text;
$share->subject = $subject;

$provider->share($share);

return;




$message = new Mail_mime();
$message->setTXTBody(strip_tags($text)); // for plain-text
$message->setHTMLBody($text);
$body = $message->get();

$host = 'smtp.gmail.com';
$port = 587; //According to Google you need to use 465 or 587
$username = 'spidernah';
$password = 'wind5791';

$headers = array('From' => $from,
    'To' => $to,
    'Subject' => $subject);

$smtp = Mail::factory('smtp',
    array(
        'host' => $host,
        'port' => $port,
        'auth' => true,
        'username' => $username,
        'password' => $password));

$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail))
{
    echo "email sending failed ".$mail;
}
else
{
    echo "ok";
}
