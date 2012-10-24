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

        $customerAdapter = new JsonCustomerAdapter();
        $purchasesAdapter = new JsonPurchasesAdapter();
        $storeAdapter = new JsonStoreAdapter();
        $branchAdapter = new JsonStoreBranchAdapter();

        $order = new Order();

        $order->amount = $obj["amount"];
        $order->id = $obj["id"];

        $order->customer = $customerAdapter->fromArray($obj["customer"]);
        $order->purchases = $purchasesAdapter->fromArray($obj["purchases"]);
        $order->store = $storeAdapter->fromArray($obj["store"]);
        $order->branch = $branchAdapter->fromArray($obj["branch"]);

        return $order;
    }
}
