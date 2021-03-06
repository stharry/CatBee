<?php

class PdoAuthorizationDao implements IAuthorizationDao
{

    public function getAuthorization($shareNode)
    {

        $rows = DbManager::selectValues("SELECT userId, accessToken FROM customerAuth
            WHERE customerId={$shareNode->leader->id}
            AND contextId={$shareNode->context->id}", array());

        if (!$rows)
        {
            return null;
        }


        $shareAuthorization = new ShareAuthorization();
        $shareAuthorization->userId = $rows[0]["userId"];
        $shareAuthorization->accessToken = $rows[0]["accessToken"];

        return $shareAuthorization;
    }

    public function setAuthorization($shareNode, $shareAuthorization)
    {
        RestLogger::log("PdoAuthorizationDao::setAuthorization start: ", array($shareNode, $shareAuthorization));

        $names = array("contextId", "customerId", "userId", "accessToken");
        $values = array($shareNode->context->id, $shareNode->leader->id,
            $shareAuthorization->userId, $shareAuthorization->accessToken);

        DbManager::insertOnly("customerAuth", $names, $values);

        RestLogger::log("PdoAuthorizationDao::setAuthorization end");

    }
}
