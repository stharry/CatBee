<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/Customer.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IModelAdapter.php");

class JsonCustomerAdapter implements IModelAdapter
{
    private function singleCustomerToArray($customer)
    {
        return array("email" => $customer->email,
            "firstName" => $customer->firstName,
            "lastName" => $customer->lastName,
            );
    }

    public function toArray($obj)
    {
        if (is_array($obj))
        {
            $customers = array();

            foreach ($obj as $customer)
            {
                array_push($customers, $this->singleCustomerToArray($customer));
            }
            return$customers;
        }
        else
        {
            return $this->singleCustomerToArray($obj);
        }
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
