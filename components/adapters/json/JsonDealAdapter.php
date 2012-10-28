<?php

class JsonDealAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        $dealAsArray = array(
            "status" => "ok",
            "id" => $obj->id
        );
        return $dealAsArray;
    }

    public function fromArray($obj)
    {
        // TODO: Implement fromArray() method.
    }
}
