<?php

class OrderTotalValidator implements  IRestrictionsValidator
{
    private $minimumValidAmount;

    function __construct($amount)
    {
        $this->minimumValidAmount = $amount;
    }

    public function isItemValid($item)
    {
        return true;
    }

    public function isOrderValid($order)
    {
        return $order->amount >= $this->minimumValidAmount;
    }
}
