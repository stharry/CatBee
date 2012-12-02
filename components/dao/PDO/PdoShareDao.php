<?php

class PdoShareDao implements IShareDao
{

    public function getShareTemplates($shareFilter)
    {
        $rows = DbManager::selectValues("SELECT id, storeId, campaignId, shareType, message, body, targetId
                  FROM StoreShareTemplate
                    WHERE (storeId = {$shareFilter->store->id} OR storeId =-1)
                      AND
                       (shareType = {$shareFilter->context->id} OR shareType =-1)
                       AND (target = {$shareFilter->targetId} OR target = 0)");

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

            $shareTemplate->target = $row["targetId"];
            array_push($shareTemplates, $shareTemplate);
        }

        return $shareTemplates;
    }

    public function insertShareTemplate($shareTemplate)
    {
        $names = array("storeId", "campaignId", "shareType", "message", 'body', 'targetId');
        $values = array($shareTemplate->store->id, $shareTemplate->campaign->id,
                        $shareTemplate->shareContext->id,
                        $shareTemplate->message,
                        $shareTemplate->templatePage->context,
                        $shareTemplate->target);

        $shareTemplate->id = DbManager::insertAndReturnId("StoreShareTemplate", $names, $values);
    }

    public function IsShareTemplateExists($shareTemplate)
    {
        $selectClause = " SELECT id FROM StoreShareTemplate
          WHERE storeId = {$shareTemplate->store->id}
            AND campaignId = {$shareTemplate->campaign->id}
            AND shareType = {$shareTemplate->shareContext->id}";

        $rows = DbManager::selectValues($selectClause);

        if ($rows == null)
        {
            RestLogger::log("PdoShareDao::IsShareTemplateExists - not exists");
            return false;
        }

        $shareTemplate->id = $rows[0]['id'];
        return true;
    }

    public function insertOrUpdateShareTemplate($shareTemplate)
    {
        if (!$this->IsShareTemplateExists($shareTemplate))
        {
            $this->insertShareTemplate($shareTemplate);
        }
        else
        {
            $sql = "UPDATE StoreShareTemplate
                        SET message=:message, body=:body
                        WHERE id=:id";

            $params = array(
                ':message' => $shareTemplate->message,
                ':body' => $shareTemplate->templatePage->context,
                ':id' => $shareTemplate->id);

            DbManager::updateValues($sql, $params);
        }
    }
}
