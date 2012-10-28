<?php

class PdoShareDao implements IShareDao
{

    public function getShareTemplates($shareFilter)
    {
        $rows = DbManager::selectValues("SELECT id, storeId, campaignId, shareType, message
                  FROM StoreShareTemplate
                    WHERE storeId =? OR storeId =-1",
            array($shareFilter->store->id => PDO::PARAM_INT));

        $shareTemplates = array();

        foreach ($rows as $row)
        {
            $shareTemplate = new ShareTemplate();
            $shareTemplate->id = $row["id"];

            $shareTemplate->store = new Store();
            $shareTemplate->store->id = $row["storeId"];

            $shareTemplate->campaign = new Campaign();
            $shareTemplate->campaign->id = $row["campaignId"];

            $shareTemplate->shareType = $row["shareType"];

            $shareTemplate->templatePage = new TemplatePage();
            $shareTemplate->templatePage->context = $row["message"];

            array_push($shareTemplates, $shareTemplate);
        }

        return $shareTemplates;
    }

    public function insertShareTemplate($shareTemplate)
    {
        $names = array("storeId", "campaignId", "shareType", "message");
        $values = array($shareTemplate->store->id, $shareTemplate->campaign->id,
                        $shareTemplate->shareContext->id,
                        $shareTemplate->templatePage->context);

        $shareTemplate->id = DbManager::insertAndReturnId("StoreShareTemplate", $names, $values);
    }

    public function IsShareTemplateExists($shareTemplate)
    {
        // TODO: Implement insertCampaignShareTemplate() method.
    }
}
