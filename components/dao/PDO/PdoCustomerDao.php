<?php

class PdoCustomerDao implements ICustomerDao
{

    public function isCustomerExists($customer)
    {
        $rows = DbManager::selectValues("SELECT id FROM customers WHERE email=?",
            array($customer->email => PDO::PARAM_STR));

        if (!isset($rows)) {
            return false;
        }
        $customer->id = $rows[0]["id"];

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

    public function loadCustomerById($id)
    {
        $rows = DbManager::selectValues("SELECT email, firstName, lastName, nickName
            FROM customers WHERE id =?",
            array($id => PDO::PARAM_INT));

        if (!isset($rows)) {
            return false;
        }

        $customer = new Customer();
        $customer->id = $id;
        $customer->email = $rows[0]["email"];
        $customer->firstName = $rows[0]["firstName"];
        $customer->lastName = $rows[0]["lastName"];
        $customer->nickName = $rows[0]["nickName"];

        return $customer;
    }
}
