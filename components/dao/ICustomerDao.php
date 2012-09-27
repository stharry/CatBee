<?php

interface ICustomerDao
{
    public function IsCustomerExists($customer);

    public function InsertCustomer($customer);

    public function UpdateCustomer($customer);
}
