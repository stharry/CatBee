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

        return $tribe;
    }

}
