<?php

include_once("../../model/dao/ICustomerDao.php");
include_once("../DbManager.php");

class PdoCustomerDao implements ICustomerDao
{

    public function isCustomerExists($customer)
    {
        $rows = DbManager::selectValues("SELECT id FROM customers WHERE email=?",
            array($customer->email => PDO::PARAM_STR));

        if (!isset($rows)) {
            return false;
        }
        $customer->id = $rows[0][0];

        return true;
    }

    public function insertCustomer($customer)
    {
        $names = array("email", "firstName", "lastName", "nickName");
        $values = array($customer->email, $customer->firstName, $customer->lastName, $customer->nickName);

        $customer->id = DbManager::insertAndReturnId("customers", $names, $values);
    }

    public function updateCustomer($customer)
    {
        // TODO: Implement UpdateCustomer() method.
    }
}
