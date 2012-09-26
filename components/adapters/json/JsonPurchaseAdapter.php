<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/Purchase.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IModelAdapter.php");

class JsonPurchaseAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        // TODO: Implement toArray() method.
    }

    public function fromArray($obj)
    {
        $purchase = new Purchase();

        $purchase->itemCode = $obj["itemCode"];
        $purchase->description = $obj["description"];
        $purchase->price = $obj["price"];
        $purchase->url = $obj["url"];

        return $purchase;
    }
}
