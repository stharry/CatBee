<?php

class StoreBranch
{
    function __construct()
    {

        $this->storeRules = array();
    }
    function AddRuleToStore($rule)
    {
        array_push($this->storeRules,$rule);
    }
    public $id;
    public $shopName;
    public $shopId;
    public $redirectUrl;
    public $logoUrl;
    public $email;
    public $adaptor;
    public $storeRules;
}
