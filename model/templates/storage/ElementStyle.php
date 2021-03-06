<?php

class ElementStyle
{
    function __construct()
    {
        $this->elements = array();
        $this->attributes = array();
    }

    public $elements;
    public $attributes;

    public function addElement($name, $value)
    {
        $this->elements[$name] = $value;
        return $this;
    }

    public function addAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    public function deleteAttribute($name)
    {
        if (array_key_exists($name, $this->attributes))
        {
            unset($this->attributes[$name]);
        }
    }
}
