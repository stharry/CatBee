<?php

class JsonCampaignAdapter implements IModelAdapter
{

    private $jsonStoreAdapter;
    private $jsonLeaderLandingAdapter;
    private $jsonFriendLandingAdapter;

    function __construct()
    {
        $this->jsonStoreAdapter = new JsonStoreAdapter();
        $this->jsonLeaderLandingAdapter = new JsonLeaderLandingAdapter();
        $this->jsonFriendLandingAdapter = new jsonFriendLandingAdapter();
    }

    private function singleCampaignToArray($campaign)
    {
        $campaignProps =
            array("name" => $campaign->name,
                "description" => $campaign->description,
                "store" => $this->jsonStoreAdapter->toArray($campaign->store),
                "landings" => $this->jsonLeaderLandingAdapter->toArray($campaign->landings),
                "friendlandings" => $this->jsonFriendLandingAdapter->toArray($campaign->friendLandings)
                );

        return $campaignProps;
    }

    public function toArray($obj)
    {
        if (is_array($obj))
        {
            $campaignsProps = array();

            foreach ($obj as $campaign)
            {
                array_push($campaignsProps, $this->singleCampaignToArray($campaign));
            }
            return $campaignsProps;
        }
        return $this->singleCampaignToArray($obj);
    }

    public function fromArray($obj)
    {
        $campaign = new Campaign();
        $campaign->name = $obj["name"];
        $campaign->description = $obj["description"];
        $campaign->store = $this->jsonStoreAdapter->fromArray($obj["store"]);
        $campaign->landings = $this->jsonLeaderLandingAdapter->fromArray($obj["landings"]);
        $campaign->friendLandings = $this->jsonFriendLandingAdapter->fromArray($obj["friendLandings"]);

        return $campaign;
    }
}
