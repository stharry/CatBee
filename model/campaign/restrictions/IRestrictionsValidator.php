<?php

interface IRestrictionsValidator
{
    public function isItemValid($item);

    public function isOrderValid($order);
}
