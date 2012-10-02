<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/model/components/IShareProvider.php");
require_once "Mail.php";
require_once "Mail/mime.php";

class EmailShareProvider implements IShareProvider
{

    public function share($share)
    {
        ob_start();

        echo $share->message;

        $body = ob_get_contents();

        ob_end_clean();

        $headers = array ('From' => $share->sendFrom,
            'To' => $share->sendTo,
            'Subject' => $share->subject);


        $mime = new Mail_mime();
        $mime->setHTMLBody($body);

        $body = $mime->get();
        $headers = $mime->headers($headers);

        $smtp = Mail::factory('smtp',
            array ('host' => $GLOBALS["smtphost"],
                'auth' => true,
                'username' => $GLOBALS["smtpuser"],
                'password' => $GLOBALS["smtppass"]));

        $mail = $smtp->send($share->sendTo, $headers, $body);

        if (PEAR::isError($mail)) {
            echo("Message_Failed");
        } else {
            echo("Message_Sent");
        }

        // TODO: Implement share() method.
    }
}
