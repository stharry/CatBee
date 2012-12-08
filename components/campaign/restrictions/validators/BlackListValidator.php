<?php

class BlackListValidator implements IRestrictionsValidator
{
    public $productCodes;

    function __constructor($productsString)
    {
        $this->productCodes = explode(";", $productsString);
    }

    public function isItemValid($item)
    {
        return !in_array($item->itemCode, $this->productCodes);
    }

    public function isOrderValid($order)
    {
        return true;
    }
}
