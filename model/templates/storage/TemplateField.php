<?php

class TemplateField
{
    function __construct()
    {
        $this->style = new ElementStyle();
    }

    public function addChild()
    {
        $child = new TemplateField();

        if (!isset($this->childFields))
        {
            $this->childFields = array();
        }
        array_push($this->childFields, $child);

        return $child;
    }

    public $loop;
    public $condition;
    public $source;
    public $linkSource;
    public $style;
    public $type;
    public $name;
    public $childFields;

}
