<?php

class TemplateSectionField
{
    function __construct()
    {
        $this->style = new ElementStyle();
    }

    public $source;
    public $style;
    public $type;
}
