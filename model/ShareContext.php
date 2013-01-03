<?php

class ShareContext
{
    function __construct($type = "tribzi")
    {
        switch (strtolower($type))
        {
            case  "email":
                $this->id = 1;
                break;

            case  "facebook":
                $this->id = 2;
                break;

            case  "twitter":
                $this->id = 3;
                break;

            case  "tribzi":
                $this->id = 1024;
                break;

            default:
                $this->id = 1;
                break;

         }
        $this->type = $type;
    }

    public $type;
    public $id;
    public $message;
    public $customMessage;
    public $link;
    public $application;
    public $uid;
}
