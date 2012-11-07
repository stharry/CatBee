<?php

interface ICustomerDao
{
    public function isCustomerExists($customer);

    public function insertCustomer($customer);

    public function updateCustomer($customer);

    public function loadCustomerById($id);
}
