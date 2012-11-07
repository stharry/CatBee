<?php

class PdoShareApplicationDao implements IShareApplicationDao
{
    public function getApplication($context)
    {
        $select = "SELECT id, oauthId, oauthKey, oauthSecret, oauthUrl, redirectUrl
                    FROM oauthApps WHERE contextId =?";
        $params = array($context->id => PDO::PARAM_INT);

        $rows = DbManager::selectValues($select, $params);

        if (!isset($rows)) {
            return false;
        }

        $application = new ShareApplication();

        $application->id = $rows[0]['id'];
        $application->applicationCode = $rows[0]['oauthId'];
        $application->applicationApiKey = $rows[0]['oauthKey'];
        $application->applicationSecret = $rows[0]['oauthSecret'];
        $application->authorizationUrl = $rows[0]['oauthUrl'];
        $application->redirectUrl = $rows[0]['redirectUrl'];

        return $application;
    }

    public function setApplication($context)
    {
        if ($this->isApplicationExists($context))
        {
            return;
        }

        $app = $context->application;
        $names = array('contextId', 'oauthId', 'oauthKey', 'oauthSecret',
                        'oauthUrl', 'redirectUrl');

        $values = array($context->id, $app->applicationCode, $app->applicationApiKey,
                        $app->applicationSecret, $app->authorizationUrl,
                        $app->redirectUrl);

        $app->id = DbManager::insertAndReturnId("oauthApps", $names, $values);
    }

    private function isApplicationExists($context)
    {
        $select = "SELECT id FROM oauthApps WHERE contextId =?";
        $params = array($context->id => PDO::PARAM_INT);

        $rows = DbManager::selectValues($select, $params);

        if (!isset($rows)) {
            return false;
        }

        return true;
    }
}
