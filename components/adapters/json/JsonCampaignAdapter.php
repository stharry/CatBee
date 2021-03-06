<?php

class JsonCampaignAdapter implements IModelAdapter
{

    private $jsonStoreAdapter;
    private $jsonStoreBranchAdapter;
    private $jsonLeaderLandingAdapter;
    private $jsonFriendLandingAdapter;
    private $jsonRestrictionsAdapter;

    function __construct()
    {
        $this->jsonStoreAdapter         = new JsonAdaptorAdapter();
        $this->jsonLeaderLandingAdapter = new JsonLeaderLandingAdapter();
        $this->jsonFriendLandingAdapter = new jsonFriendLandingAdapter();
        $this->jsonRestrictionsAdapter  = new JsonRestrictionsAdapter();
        $this->jsonStoreBranchAdapter   = new JsonStoreBranchAdapter();
    }

    private function singleCampaignToArray($campaign)
    {
        $campaignProps =
            array(
                "id"             => $campaign->id,
                "code"           => $campaign->code,
                "description"    => $campaign->description,
                'landingUrl'     => $campaign->landingUrl,
                "store"          => $this->jsonStoreBranchAdapter->toArray($campaign->store),
                "landings"       => $this->jsonLeaderLandingAdapter->toArray($campaign->landings),
                "friendlandings" => $this->jsonFriendLandingAdapter->toArray($campaign->friendLandings),
                'restrictions'   => $this->jsonRestrictionsAdapter->toArray($campaign->restrictions),

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
        $campaign                 = new Campaign();
        $campaign->id             = $obj[ "id" ];
        $campaign->code           = $obj[ "code" ];
        $campaign->description    = $obj[ "description" ];
        $campaign->landingUrl     = $obj[ 'landingUrl' ];
        $campaign->store          = $this->jsonStoreBranchAdapter->fromArray($obj[ "branch" ]);
        $campaign->landings       = $this->jsonLeaderLandingAdapter->fromArray($obj[ "landings" ]);
        $campaign->friendLandings = $this->jsonFriendLandingAdapter->fromArray($obj[ "friendLandings" ]);
        $campaign->restrictions   = $this->jsonRestrictionsAdapter->fromArray($obj[ 'restrictions' ]);

        return $campaign;
    }
}
