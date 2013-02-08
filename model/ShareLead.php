<?php

class ShareLead
{
    function __construct()
    {
        $this->referralOrders = array();
        $this->impressions = array();
    }
    public $to;
    public $landingRewardId;
    public $id;
    public $uid;
    public $shareType;
    public $orderId;
    public $status;
    public $referralOrders;
    public $impressions;

}
