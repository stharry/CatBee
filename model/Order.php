<?php

class Order
{
    function __construct()
    {
        $this->items = array();
        $this->status = new OperationStatus();
    }

    public function addItem()
    {
        $item = new PurchaseItem();
        array_push($this->items, $item);

        return $item;
    }

    public $id;
    public $amount;
    public $items;
    public $customer;
    public $branch;
    public $lead;
    public $activeShareId;
    public $status;
}
