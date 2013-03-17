<?php

class PdoCustomerDao implements ICustomerDao
{

    public function isCustomerExists($customer)
    {
        $rows = DbManager::selectValues("SELECT id FROM customers WHERE email=?",
            array(new DbParameter($customer->email,PDO::PARAM_STR)));

        if (!isset($rows)) {
            return false;
        }
        $customer->id = $rows[0]["id"];

        return true;
    }

    public function insertCustomer($customer)
    {
        $names = array("email", "firstName", "lastName", "nickName","sharedPhoto");
        $values = array($customer->email, $customer->firstName, $customer->lastName, $customer->nickName,$customer->sharedPhoto);

        $customer->id = DbManager::insertAndReturnId("customers", $names, $values);
    }

    public function updateCustomer($customer)
    {
        // TODO: Implement UpdateCustomer() method.
    }

    public function loadCustomerById($id)
    {
        $rows = DbManager::selectValues("SELECT email, firstName, lastName, nickName,sharedPhoto
            FROM customers WHERE id =?",
            array(new DbParameter($id,PDO::PARAM_INT)));

        if (!isset($rows)) {
            return false;
        }

        $customer = new Customer();
        $customer->id = $id;
        $customer->email = $rows[0]["email"];
        $customer->firstName = $rows[0]["firstName"];
        $customer->lastName = $rows[0]["lastName"];
        $customer->nickName = $rows[0]["nickName"];
        $customer->sharedPhoto = $rows[0]["sharedPhoto"];

        return $customer;
    }

    public function loadCustomerByEmail($customer)
    {
        $rows = DbManager::selectValues("SELECT firstName, lastName, nickName, id,sharedPhoto
            FROM customers WHERE email =?",
            array(new DbParameter($customer->email,PDO::PARAM_INT)));

        if (!isset($rows)) {
            return false;
        }

        $customer->id = $rows[0]["id"];
        $customer->firstName = $rows[0]["firstName"];
        $customer->lastName = $rows[0]["lastName"];
        $customer->nickName = $rows[0]["nickName"];
        $customer->sharedPhoto = $rows[0]["sharedPhoto"];
    }
}
