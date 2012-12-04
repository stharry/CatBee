<?php

class LeaderDeal
{
    public static $STATUS_UNKNOWN = 0;
    public static $STATUS_PENDING = 1;
    public static $STATUS_SHARED = 2;
    public static $STATUS_FRIEND_CHECKOUT = 3;
    public static $STATUS_CLOSED = 4;
    public static $STATUS_CANCELLED = 5;

    public $id;
    public $campaign;
    public $landing;
    public $order;
    public $status;
    public $selectedLandingReward;
    public $customer;
    //TODO - What does this Date Stand for?
    public $date;
    public $friendDeals;
    public $uniqueCode;
    public $sharePoint;
    public $dealPoint;
    public $shares;
}
