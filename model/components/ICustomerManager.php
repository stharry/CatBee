<?php

interface ICustomerManager
{
    public function validateCustomer($customer);
    public function validateAndSaveCustomer($customer);
}
