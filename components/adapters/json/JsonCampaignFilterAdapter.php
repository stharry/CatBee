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

        $campaignFilter->store = new StoreBranch();
        $campaignFilter->store->shopId= $obj["shopId"];

        return $campaignFilter;
    }
}
