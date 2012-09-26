<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/Customer.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IModelAdapter.php");

class JsonCustomerAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        // TODO: Implement toArray() method.
    }

    public function fromArray($obj)
    {
        $customer = new Customer();

        $customer->email = $obj["email"];
        $customer->firstName = $obj["firstName"];
        $customer->lastName = $obj["lastName"];
        $customer->nickName = $obj["nickName"];

        return $customer;
    }
}
