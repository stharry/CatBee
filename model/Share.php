<?php

class Share
{
    public static $SHARE_STATUS_PENDING = 1;
    public static $SHARE_STATUS_SHARED = 2;
    public static $SHARE_STATUS_CANCELLED = 3;

    public $id;
    public $sendFrom;
    public $sendTo;
    public $subject;
    public $message;
    public $store;
    public $campaign;
    public $context;
    public $reward;
    public $link;
    public $deal;
    public $status;

    public function isShared()
    {
        return $this->status === Share::$SHARE_STATUS_SHARED;
    }
}
