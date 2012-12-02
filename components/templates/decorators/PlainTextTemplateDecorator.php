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

    public function decorateFieldHeader($field, $value, $link)
    {
        return '';
    }

    public function decorateFieldFooter($field, $value, $link)
    {
        return '';
    }

    public function getLineBreak()
    {
        return '\r\n';
    }
}
