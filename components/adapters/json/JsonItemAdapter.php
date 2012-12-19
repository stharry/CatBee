<?php

class JsonItemAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        return array(
            'itemcode'    => $obj->itemCode,
            'description' => $obj->description,
            'price'       => $obj->price,
            'url'         => $obj->url,
            'discount'    => $obj->discount,
            'couponCode'  => $obj->couponCode
        );
    }

    public function fromArray($obj)
    {
        $item = new PurchaseItem();

        $item->itemCode    = $obj[ "itemcode" ];
        $item->description = $obj[ "description" ];
        $item->price       = $obj[ "price" ];
        $item->url         = $obj[ "url" ];
        $item->discount    = $obj[ "discount" ];
        $item->couponCode  = $obj[ "couponCode" ];

        return $item;
    }
}
