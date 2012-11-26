<?php

class PlainTextTemplateDecorator implements ITemplateDecorator
{

    public function decorateField($field, $value, $link)
    {
        return $value.' '.$link;
    }

    public function decorateSectionHeader($section)
    {
        return '';
    }

    public function decorateSectionFooter($section)
    {
        return '';
    }

    public function decorateTemplateHeader($template)
    {
        return '';
    }

    public function decorateTemplateFooter($template)
    {
        return '';
    }
}
