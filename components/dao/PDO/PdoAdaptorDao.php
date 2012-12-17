<?php

class PdoAdaptorDao implements IAdaptorDao
{

    public function isAdaptorExists($adaptor)
    {
        if ($adaptor->id > 0) return true;
        $rows = DbManager::selectValues("SELECT id FROM Adaptor  WHERE authCode=?",
            array($adaptor->authCode => PDO::PARAM_STR));
        if (!isset($rows)) {
            return false;
        }
        $adaptor->id = $rows[0]["id"];

        return true;
    }

    public function insertAdaptor($adaptor)
    {
        $names = array("authCode", "description", "url", "logoUrl");
        $values = array(
            $adaptor->authCode,
            $adaptor->description,
            $adaptor->url,
            $adaptor->logoUrl);

        $adaptor->id = DbManager::insertAndReturnId("adaptor", $names, $values);
    }

    public function loadAdaptor($adaptor)
    {
        $rows = DbManager::selectValues("SELECT id, description, url, logoUrl FROM adaptor  WHERE authCode=?",
            array($adaptor->authCode => PDO::PARAM_STR));

        if (!isset($rows)) {
            return false;
        }
        $adaptor->id = $rows[0]["id"];
        $adaptor->description = $rows[0]["description"];
        $adaptor->url = $rows[0]["url"];
        $adaptor->logoUrl = $rows[0]["logoUrl"];

        return true;
    }
}
