<?php

class ElementStyle
{
    function __construct()
    {
        $this->elements = array();
    }

    public $elements;

    public function addElement($name, $value)
    {
        $this->elements[$name] = $value;
        return $this;
    }
}
