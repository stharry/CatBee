<?php


class TribeManager
{

    private $TribeDao;


    function __construct()
    {
        $this->TribeDao = new PdoTribeDao();
    }
    public function GetTribe($tribeFilter)
    {
        $tribe = $this->TribeDao->getTribe($tribeFilter);
        //Extract from the Tribe a list of Stores and send them to StoreDao
        //I have an array of Stores i need to create a list of

        return $tribe;
    }

}
