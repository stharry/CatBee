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
    public $customer;
    public $sharePoint;  //currently used as a JavaScript client callback url to the TribZi server
    public $shares;
    public $fbcContext;//social application details for facebook. Used in the facebook.js only
    public $twitContext;//same for twitter
    public $InitDate;
    public $leads;
}
