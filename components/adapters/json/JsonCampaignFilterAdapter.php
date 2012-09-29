<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/CampaignFilter.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IModelAdapter.php");

class JsonCampaignFilterAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        // TODO: Implement toArray() method.
    }

    public function fromArray($obj)
    {
        $campaignFilter = new CampaignFilter();

        $campaignFilter->storeCode = $obj["storeCode"];

        return $campaignFilter;
    }
}
