<?php

class PdoShareDao implements IShareDao
{

    public function getShareTemplates($shareFilter)
    {
        $rows = DbManager::selectValues("SELECT id, shareType, message, body, targetId
                  FROM CampaignShareTemplate
                    WHERE
                       (shareType = {$shareFilter->context->id})
                       AND
                       (targetId = {$shareFilter->targetId})
                       AND
                       (campaignId = {$shareFilter->campaign->id})", null);

        $shareTemplates = array();

        foreach ($rows as $row)
        {
            $shareTemplate = new ShareTemplate();
            $shareTemplate->id = $row["id"];

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

        $names = array("campaignId", "shareType", "message",
                        'body',
                        'targetId');

        $values = array($shareTemplate->campaign->id,
                        $shareTemplate->shareContext->id,
                        $shareTemplate->message,
                        $shareTemplate->templatePage->context,
                        $shareTemplate->target->id);

        $shareTemplate->id = DbManager::insertAndReturnId("CampaignShareTemplate", $names, $values);
    }

    public function IsShareTemplateExists($shareTemplate)
    {
        $selectClause = " SELECT id FROM CampaignShareTemplate
          WHERE campaignId = {$shareTemplate->campaign->id}
            AND shareType = {$shareTemplate->shareContext->id}
            AND targetId = {$shareTemplate->target->id}";

        $rows = DbManager::selectValues($selectClause,null);

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
            $sql = "UPDATE CampaignShareTemplate
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
