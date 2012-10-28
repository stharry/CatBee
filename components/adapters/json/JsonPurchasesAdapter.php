<?php

class JsonPurchasesAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        // TODO: Implement toArray() method.
    }

    public function fromArray($obj)
    {
        $jsonPurchaseAdapter = new JsonPurchaseAdapter();
        $purchases = array();

        foreach ($obj as $purchase)
        {
            array_push($purchases, $jsonPurchaseAdapter->toArray($purchase));
        }

        return $purchases;
    }
}
