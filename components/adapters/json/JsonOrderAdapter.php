<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/Order.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IModelAdapter.php");
include_once("JsonCustomerAdapter.php");
include_once("JsonPurchasesAdapter.php");

class JsonOrderAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        // TODO: Implement toArray() method.
    }

    public function fromArray($obj)
    {

        $jsonCustomerAdapter = new JsonCustomerAdapter();
        $jsonPurchasesAdapter = new JsonPurchasesAdapter();

        $orderProps = $obj["order"];


        $order = new Order();

        $order->amount = $orderProps["amount"];

        $order->customer = $jsonCustomerAdapter->fromArray($orderProps["customer"]);

        $order->purchases = $jsonPurchasesAdapter->fromArray($orderProps["purchases"]);

        return $order;
    }
}
