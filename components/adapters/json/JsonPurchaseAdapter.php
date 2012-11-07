<?php

class JsonPurchaseAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        return array(
            'itemCode' => $obj->itemCode,
            'description' => $obj->description,
            'price' => $obj->price,
            'url' => $obj->url
        );
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
