<?php

class JsonItemAdapter implements IModelAdapter
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
        $item = new PurchaseItem();

        $item->itemCode = $obj["itemCode"];
        $item->description = $obj["description"];
        $item->price = $obj["price"];
        $item->url = $obj["url"];

        return $item;
    }
}
