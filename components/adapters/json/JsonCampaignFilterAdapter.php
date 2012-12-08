<?php

class JsonCampaignFilterAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        // TODO: Implement toArray() method.
    }

    public function fromArray($obj)
    {
        $campaignFilter = new CampaignFilter();

        $campaignFilter->store = new Store();
        $campaignFilter->store->authCode = $obj["storeCode"];

        return $campaignFilter;
    }
}
