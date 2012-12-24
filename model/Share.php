<?php

class Share
{


    function __construct()
    {
        $this->successfulReferrals = array();
    }
    public function addReferral()
    {
        $successfulReferral = new SuccessfulReferral();
        array_push($this->successfulReferrals, $successfulReferral);

        return $successfulReferral;
    }

    public static $SHARE_STATUS_PENDING = 1;
    public static $SHARE_STATUS_SHARED = 2;
    public static $SHARE_STATUS_CANCELLED = 3;

    public $id;
    public $sendFrom;
    public $sendTo;
    public $subject;
    public $message;
    public $customMessage;
    public $campaign;
    //The Context Reperesent data on the share for example the Sharing Method
    //TODO - Consider change the names
    public $context;
    public $reward;
    public $link;
    public $deal;
    public $status;
    public $successfulReferrals;


    public function isShared()
    {
        return $this->status === Share::$SHARE_STATUS_SHARED;
    }
}
