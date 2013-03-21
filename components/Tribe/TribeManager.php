<?php


class TribeManager
{

    private $TribeDao;
    private $StoreRulesDao;


    function __construct()
    {
        $this->TribeDao = new PdoTribeDao();
        $this->StoreRulesDao = new PdoStoreRulesDao();

    }
    public function GetTribe($tribeFilter)
    {
        $tribe = $this->TribeDao->getTribe($tribeFilter);
        //Extract from the Tribe a list of Stores and send them to StoreDao
        //I have an array of Stores i need to create a list of
        $this->StoreRulesDao->FillStoreRules($tribe);
        return $tribe;
    }

}
