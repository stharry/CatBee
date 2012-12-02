<?php

interface ITemplateDecorator
{
    public function decorateFieldHeader($field, $value, $link);

    public function decorateFieldFooter($field, $value, $link);

    public function decorateField($field, $value, $link);

    public function decorateSectionHeader($section);

    public function decorateSectionFooter($section);

    public function decorateTemplateHeader($template);

    public function decorateTemplateFooter($template);

    public function getLineBreak();
}
