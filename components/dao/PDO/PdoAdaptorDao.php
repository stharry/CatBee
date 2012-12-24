<?php

class PdoAdaptorDao implements IAdaptorDao
{
    private function fillAdaptor($adaptor, $row)
    {
        $adaptor->id = $row["id"];
        $adaptor->authCode = $row["authCode"];
        $adaptor->description = $row["description"];
        $adaptor->url = $row["url"];
        $adaptor->logoUrl = $row["logoUrl"];

    }

    public function isAdaptorExists($adaptor)
    {
        if ($adaptor->id > 0) return true;
        $rows = DbManager::selectValues("SELECT id FROM Adaptor  WHERE authCode=?",
            array(new DbParameter($adaptor->authCode, PDO::PARAM_STR)));
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
        $rows = DbManager::selectValues("SELECT id, authCode, description, url, logoUrl FROM adaptor  WHERE authCode=?",
            array(new DbParameter($adaptor->authCode, PDO::PARAM_STR)));

        if (!isset($rows)) {
            return false;
        }

        $this->fillAdaptor($adaptor, $rows[0]);

        return true;
    }

    public function loadAdaptorById($adaptor)
    {
        $rows = DbManager::selectValues(
            "SELECT id, authCode, description, url, logoUrl FROM adaptor
             WHERE id=?",
            array(new DbParameter($adaptor->id, PDO::PARAM_INT)));

        if (!isset($rows)) {
            return false;
        }

        $this->fillAdaptor($adaptor, $rows[0]);

        return true;
    }


}
