<?php

class PdoRewardDao implements IRewardDao
{
    public function fillRewardById($reward)
    {
        $rows = DbManager::selectValues("SELECT code, rewardDesc, rewardTypeDesc,
                  type, value
            FROM reward WHERE id =?",
            array(new DbParameter($reward->id,PDO::PARAM_INT)));

        if (!isset($rows)) {
            return false;
        }

        $reward->code = $rows[0]["code"];
        $reward->description = $rows[0]["rewardDesc"];
        $reward->typeDescription = $rows[0]["rewardTypeDesc"];
        $reward->type = $rows[0]["type"];
        $reward->value = $rows[0]["value"];

        return $reward;
    }
}
