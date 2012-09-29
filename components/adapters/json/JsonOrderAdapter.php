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

        $order = new Order();

        $order->amount = $obj["amount"];
        $order->id = $obj["id"];

        $order->customer = $jsonCustomerAdapter->fromArray($obj["customer"]);

        $order->purchases = $jsonPurchasesAdapter->fromArray($obj["purchases"]);

        $order->store = $jsonStoreAdapter->fromArray($obj["store"]);
        return $order;
    }
}
