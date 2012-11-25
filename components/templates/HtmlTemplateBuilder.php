<?php

class HtmlTemplateBuilder extends TemplateBuilder
{
    private function style2String($style)
    {
        if (!$style || (count($style->elements) == 0))
        {
            return '';
        }

        $styleAsString = " style=\"";
        foreach ($style->elements as $propName => $propValue)
        {
            $styleAsString .= $propName.': '.$propValue.';';
        }
        $styleAsString .= "\"";

        return $styleAsString;
    }

    private function width2String($width)
    {
        if(!$width || ($width == '0'))
        {
            return '';
        }

        return " width=\"$width\" height=\"300\"";
    }

    protected function buildTemplateHeader($template)
    {
        $result = "<html><head></head><body>";
        $result .= "<table id=\"template\""
            .$this->style2String($template->style)
            .$this->width2String($template->width).">";

        return $result;
    }

    protected function buildTemplateFooter($template)
    {
        return "</table></body></html>";

    }

    protected function buildSectionHeader()
    {
        return "<td".$this->style2String($this->getCurrentSection()->style).">";
    }

    protected function buildSectionFooter()
    {
        return "</td>";
    }

    protected function buildFieldHeader()
    {
        switch ($this->getCurrentField()->type)
        {
            case 'image':
                return "<img".$this->style2String($this->getCurrentField()->style)." src=\"";

            default:
                return "<div".$this->style2String($this->getCurrentField()->style).">";
        }


    }

    protected function buildFieldFooter()
    {
        switch ($this->getCurrentField()->type)
        {
            case 'image':
                return "\">";

            default:
                return "</div>";
        }
    }


}
