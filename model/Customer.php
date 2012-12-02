<?php

class Customer
{
    function __construct($email = '')
    {
        $this->email = $email;
    }

    public $id;
    public $email;
    public $firstName;
    public $lastName;
    public $nickName;
    public $sharedPhoto;
    public $sharedUserId;
}
