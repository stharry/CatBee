<?php

class DbParameter
{
    function __construct($pValue, $pType)
    {
        $this->paramValue = $pValue;
        $this->paramType = $pType;

    }

    public $paramValue;
    public $paramType;
}
