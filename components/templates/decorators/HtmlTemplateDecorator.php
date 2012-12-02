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
        return '';
    }

    public function decorateSectionHeader($section)
    {
        return "<tr><td".$this->allStyle($section->style).">\n";
    }

    public function decorateSectionFooter($section)
    {
        return "</td></tr>\n";
    }

    public function decorateTemplateHeader($template)
    {
        $result = "<html><head></head><body>";
        $result .= "<table id=\"template\""
            .$this->allStyle($template->style).">\n";

        return $result;
    }

    public function decorateTemplateFooter($template)
    {
        return "</table></body></html>";
    }

    public function decorateFieldHeader($field, $value, $link)
    {
        switch ($field->type)
        {
            case 'image':
                return "<img".$this->allStyle($field->style)." src=\"".$value."\">";

            case 'button':
                return "<a".$this->allStyle($field->style)." href=\"".$link."\">".$value;

            case 'line':
                return '<hr>';

            case 'caret':
                return '<br>';

            case 'text':
                if (isset($link) && !empty($link))
                {
                    return "<".$field->name.$this->allStyle($field->style)." href=\"".$link."\">".$value;
                }
                else
                {
                    return "<".$field->name.$this->allStyle($field->style).">".$value;
                }

            default:
                return '';
        }
    }

    public function decorateFieldFooter($field, $value, $link)
    {
        switch ($field->type)
        {
            case 'image':
                return "\n";

            case 'button':
                return "</a>\n";

            case 'text':
                return "</".$field->name.">\n";

            default:
                return '';
        }
    }

    public function getLineBreak()
    {
        return '<br>';
    }
}
