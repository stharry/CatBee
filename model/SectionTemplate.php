<?php

class EmailSectionBackgroundTemplate
{
    public $color;
}

class EmailSectionForegroundTemplate
{
    public $font;
    public $message;
}

class EmailSectionTemplate
{
    public $background;
    public $foreground;
}


class EmailTemplateHeader
{
    public $imageUrl;
}

class EmailTemplateFooter
{
    public $imageUrl;
}

class EmailTemplateBody
{
    public $sections;
}

class EmailTemplate
{
    public $header;
    public $body;
    public $footer;

}
