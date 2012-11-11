<?php

require_once "Mail.php";
require_once "Mail/mime.php";

class EmailShareProvider implements IShareProvider
{

    private function validateEmailAddress($address)
    {
        $addresses = explode(',', $address);

        $result = '';

        foreach ($addresses as $singleAddress)
        {
            $result .= substr($singleAddress, 0, strpos($singleAddress, '@'))
                .' '.'<'.$singleAddress.'>,';
        }
        return $result;
    }

    public function share($share)
    {
        ob_start();

        echo $share->message;

        $body = ob_get_contents();

        ob_end_clean();

        $headers = array ('From' => $this->validateEmailAddress($share->sendFrom),
            'To' => $this->validateEmailAddress($share->sendTo),
            'Subject' => $share->subject);


        $mime = new Mail_mime();
        $mime->setHTMLBody($body);

        $body = $mime->get();
        $headers = $mime->headers($headers);

        $smtp = Mail::factory('smtp',
            array ('host' => $GLOBALS["smtphost"],
                'auth' => true,
                'username' => $GLOBALS["smtpuser"],
                'password' => $GLOBALS["smtppass"],
                'port' => $GLOBALS['smtpport']));

        RestLogger::log('email headers: ', $headers);
        RestLogger::log('email body: ', $body);

        $mail = $smtp->send($share->sendTo, $headers, $body);

        if (PEAR::isError($mail))
        {
            RestLogger::log("email sending failed ".$mail);
            return false;
        }
        else
        {
            RestLogger::log("email sent");
            return true;
        }

    }

    public function getContacts($customer)
    {
        // TODO: Implement getContacts() method.
    }

    public function requiresAuthentication($shareNode)
    {
        return false;
    }

    public function getAuthenticationUrl($shareNode, $params)
    {
        return "";
    }

    public function getCurrentSharedCustomer()
    {
        // TODO: Implement getCurrentSharedCustomer() method.
    }
}
