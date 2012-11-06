<?php

class PdoShareDao implements IShareDao
{

    public function getShareTemplates($shareFilter)
    {
        $rows = DbManager::selectValues("SELECT id, storeId, campaignId, shareType, message, body
                  FROM StoreShareTemplate
                    WHERE (storeId = {$shareFilter->store->id} OR storeId =-1)
                      AND
                       (shareType = {$shareFilter->context->id} OR shareType =-1)");

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
            $shareTemplate->message = $row["message"];

            $shareTemplate->templatePage = new TemplatePage();
            $shareTemplate->templatePage->context = $row["body"];

            array_push($shareTemplates, $shareTemplate);
        }

        return $shareTemplates;
    }

    public function insertShareTemplate($shareTemplate)
    {
        $names = array("storeId", "campaignId", "shareType", "message", 'body');
        $values = array($shareTemplate->store->id, $shareTemplate->campaign->id,
                        $shareTemplate->shareContext->id,
                        $shareTemplate->message,
                        $shareTemplate->templatePage->context);

        $shareTemplate->id = DbManager::insertAndReturnId("StoreShareTemplate", $names, $values);
    }

    public function IsShareTemplateExists($shareTemplate)
    {
        // TODO: Implement insertCampaignShareTemplate() method.
    }
}
