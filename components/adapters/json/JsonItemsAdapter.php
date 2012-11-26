<?php

class JsonItemsAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        $itemAdapter = new JsonItemAdapter();
        $itemsProps = array();

        foreach ($obj as $item)
        {
            array_push($itemsProps, $itemAdapter->toArray($item));
        }

        return $itemsProps;
    }

    public function fromArray($obj)
    {
        $itemAdapter = new JsonItemAdapter();
        $items = array();

        foreach ($obj as $itemProps)
        {
            RestLogger::log("JsonItemsAdapter::fromArray one item", $itemProps);
            array_push($items, $itemAdapter->fromArray($itemProps));
        }

        return $items;
    }
}
