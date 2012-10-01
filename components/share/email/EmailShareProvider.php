<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/model/components/IShareProvider.php");

class EmailShareProvider implements IShareProvider
{

    public function share($share)
    {

        echo $share->message;
        // TODO: Implement share() method.
    }
}
