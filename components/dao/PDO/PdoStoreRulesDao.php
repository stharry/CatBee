<?php

class PdoStoreRulesDao
{
    public function FillStoreRules($tribe)
    {
        RestLogger::log("PdoStoreRulesDao:: begin");
        //There is an assumption the Tribe Store Arrays is order by store id
        $stores = array();
        $selectParams = array();

        foreach ($tribe->activeStores as $store)
        {
            array_push($stores,$store->id);
        }
        $selectClause = " select R.id,R.name,R.description,R.actionTriger,R.reward,R.type,R.rewardval,SR.storeid ";
        $selectClause = $selectClause . " FROM rule as R inner join storerules SR on R.id=SR.ruleid";
        $selectClause = $selectClause ." inner join tribestores TS on TS.StoreID=SR.storeid";
        $selectClause = $selectClause ." where TS.TribeID = ? and TS.StoreID in (";
        foreach ($stores as $storeid)
        {
             $selectClause = $selectClause . $storeid . ",";
        }
        $selectClause = rtrim($selectClause,",");
        $selectClause = $selectClause . ")";
        $selectClause = $selectClause." Order By SR.storeid";
        $selectParam = new DbParameter($tribe->id, PDO::PARAM_INT);
        array_push($selectParams, $selectParam);
        $rows = DbManager::selectValues($selectClause, $selectParams);
        //Fill the StoreRules at the StoreBranches

        $rowsIndex=0;
        $currentStoreIndex=0;
        while($currentStoreIndex < count($tribe->activeStores))
        {
            if($tribe->activeStores[$currentStoreIndex]->id == $rows[$rowsIndex]['storeid'])
            {
                $NewRule = new StoreRule();
                $NewRule->id = $rows[$rowsIndex]['id'];
                $NewRule->name = $rows[$rowsIndex]['name'];
                $NewRule->description = $rows[$rowsIndex]['description'];
                $NewRule->actionTriger = $rows[$rowsIndex]['actionTriger'];
                $NewRule->ruleReward = $rows[$rowsIndex]['reward'];
                $tribe->activeStores[$currentStoreIndex]->AddRuleToStore($NewRule);
                $rowsIndex = $rowsIndex+1;
            }
            else
            {
                $currentStoreIndex = $currentStoreIndex+1;
            }
        }




    }

}
