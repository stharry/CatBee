<?php

class Template
{
    function __construct()
    {
        $this->style = new ElementStyle();
        $this->sections = array();
    }

    public function addSection()
    {
        $result = new TemplateSection();
        array_push($this->sections, $result);

        return $result;
    }

    public $style;
    public $sections;
    public $width;
}
