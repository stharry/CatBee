<?php

interface ITemplateDecorator
{
    public function decorateField($field, $value, $link);

    public function decorateSectionHeader($section);

    public function decorateSectionFooter($section);

    public function decorateTemplateHeader($template);

    public function decorateTemplateFooter($template);
}
