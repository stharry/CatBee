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
    public function addImpression()
    {
        $impression = new Impression();
        array_push($this->impressions, $impression);

        return $impression;
    }
    public static $SHARE_STATUS_PENDING = 1;
    public static $SHARE_STATUS_SHARED = 2;
    public static $SHARE_STATUS_CANCELLED = 3;

    public function addTarget($to)
    {
        if (!$this->targets)
        {
            $this->targets = array();
        }
        $target = new ShareTarget('friend');
        $target->to = $to;

        return $target;
    }

    public $id;
    public $subject;
    public $message;
    public $customMessage;
    public $campaign;
    //The Context Represent data on the share for example the Sharing Method
    //TODO - Consider change the names
    public $context;
    public $reward;
    public $deal;
    public $targets;
    public $currentTarget;
    public $status;
    public $urlShare;
    public $impressions;
    public $successfulReferrals;


    public function isShared()
    {
        return $this->status === Share::$SHARE_STATUS_SHARED;
    }
}
