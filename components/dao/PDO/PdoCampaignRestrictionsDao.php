<?php

class PdoCampaignRestrictionsDao implements ICampaignRestrictionsDao
{
    private function createRestrictions($rows)
    {
        if (!isset($rows) || (count($rows) == 0)) {
            return null;
        }

        $restrictions = array();

        foreach ($rows as $row) {
            $restriction              = new CampaignRestriction();
            $restriction->id          = $row['id'];
            $restriction->name        = $row['name'];
            $restriction->description = $row['description'];
            $restriction->code        = $row['code'];
            $restriction->expression  = json_decode($row['expression'], true);

            array_push($restrictions, $restriction);
        }

        return $restrictions;

    }

    public function saveCampaignRestrictions($campaign)
    {
        $names = array('name', 'campaignId', 'description', 'code', 'expression');

        foreach ($campaign->restrictions as $restriction)
        {
            $values = array($restriction->name, $campaign->id,
                $restriction->description, $restriction->code,
                json_encode($restriction->expression));

            $restriction->id = DbManager::insertAndReturnId(
                'CampaignRestrictions', $names, $values);
        }
    }

    public function getCampaignRestrictionsByCampaignId($id)
    {
        $select = "SELECT id, name, description, code, expression
                    FROM CampaignRestrictions WHERE campaignId = {$id}";

        $rows = DbManager::selectValues($select, array());

        return $this->createRestrictions($rows);
    }

    public function deleteCampaignRestrictions($campaign)
    {
        $delete = "DELETE FROM CampaignRestrictions WHERE campaignId = {$campaign->id}";

        DbManager::selectValues($delete, array());
    }

    public function getCampaignRestrictionsByActiveShareId($id)
    {
        $select = "SELECT r.id, r.name, r.description, r.code, r.expression
                    FROM CampaignRestrictions r
                    INNER JOIN Campaign c ON r.campaignId = c.id
                     INNER JOIN deal d ON c.id = d.campaignId
                     INNER JOIN ActiveShare a ON a.dealId = d.id
                     WHERE a.id = {$id}";

        $rows = DbManager::selectValues($select, array());

        return $this->createRestrictions($rows);
    }
}
