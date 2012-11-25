<?php

class TemplateSection
{
    function __construct()
    {
        $this->style = new ElementStyle();
        $this->fields = array();
    }

    public function addField()
    {
        $result = new TemplateSectionField();
        array_push($this->fields, $result);

        return $result;
    }

    public $style;
    public $source;
    public $condition;
    public $fields;
}
