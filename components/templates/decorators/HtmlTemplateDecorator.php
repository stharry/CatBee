<?php

class HtmlTemplateDecorator implements ITemplateDecorator
{
    private function attrs2String($style)
    {
        if (!$style || (count($style->attributes) == 0))
        {
            return '';
        }

        $styleAsString = " ";
        foreach ($style->attributes as $propName => $propValue)
        {
            $styleAsString .= $propName."=\"".$propValue."\" ";
        }

        return $styleAsString;

    }

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

    private function allStyle($style)
    {
        return $this->attrs2String($style)." ".$this->style2String($style);
    }

    public function decorateField($field, $value, $link)
    {
        switch ($field->type)
        {
            case 'image':
                return "<img".$this->allStyle($field->style)." src=\"".$value."\">";

            case 'button':
                return "<a".$this->allStyle($field->style)." href=\"".$link."\">".$value."</a>";

            default:
                return "<span".$this->allStyle($field->style).">".$value."</span>";
        }
    }

    public function decorateSectionHeader($section)
    {
        return "<tr><td".$this->allStyle($section->style).">";
    }

    public function decorateSectionFooter($section)
    {
        return "</td></tr>";
    }

    public function decorateTemplateHeader($template)
    {
        $result = "<html><head></head><body>";
        $result .= "<table id=\"template\""
            .$this->allStyle($template->style).">";

        return $result;
    }

    public function decorateTemplateFooter($template)
    {
        return "</table></body></html>";
    }
}
