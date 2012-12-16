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
    public $sharedPhoto;  // link to facebook user profile photo
    public $sharedUserId; // in common case facebook user unique id
}
