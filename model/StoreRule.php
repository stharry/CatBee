<?php

class StoreRule
{
    function __construct()
    {
        $this->conditions = array();
    }
    function AddConditionToRule($condition)
    {
        array_push($this->conditions,$condition);
    }
    public $conditions;//In a different table
    public $name;
    public $id;
    public $ruleReward;//ID
    public $type;
    public $actionTriger;//ID
    public $description;

}
