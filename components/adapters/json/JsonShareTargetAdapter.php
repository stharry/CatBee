<?php

class JsonShareTargetAdapter implements IModelAdapter
{
    public function toArray($obj)
    {
        return array("name" => $obj->name);
    }

    public function fromArray($obj)
    {
        if (isset($obj) && isset($obj[ 'name' ]))
        {
            return new ShareTarget($obj[ 'name' ]);
        }
        else
        {
            return new ShareTarget();
        }
    }
}
