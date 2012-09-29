<?php

include_once("JsonStoreAdapter.php");
include_once("JsonLeaderLandingAdapter.php");
include_once("JsonRewardAdapter.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/Campaign.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IModelAdapter.php");

class JsonCampaignAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        // TODO: Implement toArray() method.
    }

    public function fromArray($obj)
    {
        $campaign = new Campaign();
        $campaign->name = $obj["name"];
        $campaign->description = $obj["description"];

        $jsonStoreAdapter = new JsonStoreAdapter();
        $campaign->store = $jsonStoreAdapter->fromArray($obj["store"]);

        $jsonLeaderLandingAdapter = new JsonLeaderLandingAdapter();
        $campaign->landings = $jsonLeaderLandingAdapter->fromArray($obj["landings"]);

        return $campaign;
    }
}
