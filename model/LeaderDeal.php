<?php

class LeaderDeal
{
    public static $STATUS_UNKNOWN = 0;
    public static $STATUS_PENDING = 1;
    public static $STATUS_FRIEND_CHECKOUT = 2;
    public static $STATUS_CLOSED = 3;
    public static $STATUS_CANCELLED = 4;

    public $id;
    public $landing;
    public $order;
    public $status;
    public $selectedLandingReward;
    public $customer;
    public $date;
    public $friendDeals;
    public $uniqueCode;
    public $sharePoint;
}
