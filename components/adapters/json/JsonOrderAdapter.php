<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/Order.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IModelAdapter.php");
include_once("JsonCustomerAdapter.php");
include_once("JsonPurchasesAdapter.php");
include_once("JsonStoreAdapter.php");

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
        $jsonStoreAdapter = new JsonStoreAdapter();

        $orderProps = $obj["order"];


        $order = new Order();

        $order->amount = $orderProps["amount"];

        $order->customer = $jsonCustomerAdapter->fromArray($orderProps["customer"]);

        $order->purchases = $jsonPurchasesAdapter->fromArray($orderProps["purchases"]);

        $order->store = $jsonStoreAdapter->fromArray($orderProps["store"]);
        return $order;
    }
}
