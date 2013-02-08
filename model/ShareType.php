<?php

class ShareType
{
    function __construct($type = "tribzi")
    {
        switch (strtolower($type))
        {
            case  "email":
                $this->type = 1;
                break;

            case  "facebook":
                $this->type = 2;
                break;
            case  "twitter":
                $this->type = 3;
                break;

            case  "tribzi":
                $this->type = 1024;
                break;

            default:
                $this->type = 1;
                break;

        }
    }
    public $type;
}
