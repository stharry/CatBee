<?php

//error_reporting(E_ALL);
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors',1);
//set_include_path('pear');

require_once "Mail.php";
require_once "Mail/mime.php";

$from = "Shukis <regev147@013.net>";
$to = $_POST["email"];
$subject = "Hi!";
$messageToFriend = $_POST["msg"];

ob_start();

include_once('mailViewTest.php');
//include_once('mailViewTestAsHtml.html');
$body = ob_get_contents();
ob_end_clean();

$host = "mail.013.net";
$username = "regev147";
$password = "wind5791";

$headers = array ('From' => $from,
    'To' => $to,
    'Subject' => $subject);

$mime = new Mail_mime();
$mime->setHTMLBody($body);

$body = $mime->get();
$headers = $mime->headers($headers);

$smtp = Mail::factory('smtp',
    array ('host' => $host,
        'auth' => true,
        'username' => $username,
        'password' => $password));

$mail = $smtp->send($to, $headers, $body);

echo "--------Before sending";

if (PEAR::isError($mail)) {
    echo("Message_Failed");
} else {
    echo("Message_Sent");
}
?>