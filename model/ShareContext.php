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

            case  "pinterest":
                $this->id = 4;
                break;

            case  "urlShare":
                $this->id = 5;
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

    public static function id2Type($id)
    {
        $idTypePairs = array(1 => 'email', 2 => 'facebook',
                             3 => 'twitter', 4 => 'pinterest',
                             5 => 'share', 1024 => 'tribzi');

        if (!array_key_exists($id, $idTypePairs))
        {
            return $idTypePairs[1];
        }

        return $idTypePairs[$id];
    }

    public $type;
    public $id;
    public $message;
    public $customMessage;
    public $link;
    public $application;
    public $uid;
}
