<?php

class JsonShareFilterAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        // TODO: Implement toArray() method.
    }

    public function fromArray($obj)
    {
        $shareFilter = new ShareFilter();

        //todo: use appropriate adapters for store and campaign
        $shareFilter->store = new Store();
        $shareFilter->store->authCode = $obj["store"]["authCode"];

        return $shareFilter;
    }
}
