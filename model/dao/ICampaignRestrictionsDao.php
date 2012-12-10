<?php

interface ICampaignRestrictionsDao
{
    public function saveCampaignRestrictions($campaign);

    public function getCampaignRestrictionsByCampaignId($id);

    public function getCampaignRestrictionsByActiveShareId($id);

    public function deleteCampaignRestrictions($campaign);
}
