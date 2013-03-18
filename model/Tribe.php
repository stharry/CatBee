<?php

class Tribe
{

    function __construct()
    {

        $this->customers = array();
        $this->activeStores = array();
    }
    function AddCustomerToTribe($customer)
    {
        array_push($this->customers,$customer);
    }
    function AddActiveStoreToTribe($store)
    {
        array_push($this->activeStores,$store);
    }
    public $customers;
    public $TribeName;
    public $id;
    public $activeStores;
}
