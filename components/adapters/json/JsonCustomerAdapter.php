<?php

class JsonCustomerAdapter implements IModelAdapter
{
    private function singleCustomerToArray($customer)
    {
        return array("email" => $customer->email,
            "firstName" => $customer->firstName,
            "lastName" => $customer->lastName,
            "sharedUserId" => $customer->sharedUserId,
            "sharedPhoto" => $customer->sharedPhoto
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
        //To do  - This need to be generic to all the parameters at The Rest API and not specific here
        $customer->email = urldecode($customer->email);
        $customer->firstName = $obj["firstName"];
        $customer->lastName = $obj["lastName"];
        $customer->nickName = $obj["nickName"];

        if (isset($obj["sharedUserId"]))
        {
            $customer->sharedUserId = $obj["sharedUserId"];
        }
        if (isset($obj["sharedPhoto"]))
        {
            $customer->sharedPhoto = $obj["sharedPhoto"];
        }
        return $customer;
    }
}
