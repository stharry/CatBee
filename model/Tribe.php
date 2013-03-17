<?php

class Tribe
{

    function __construct()
    {

        $this->customers = array();
    }
    function AddCustomerToTribe($customer)
    {
        array_push($this->customers,$customer);
    }
    public $customers;
    public $TribeName;
    public $id;
}
