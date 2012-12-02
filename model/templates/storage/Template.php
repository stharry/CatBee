<?php

class Template
{
    function __construct()
    {
        $this->style = new ElementStyle();
        $this->fields = array();
    }

    public function addField()
    {
        $result = new TemplateField();
        $result->loop = '1';
        array_push($this->fields, $result);

        return $result;
    }

    public $style;
    public $fields;
    public $width;
}
