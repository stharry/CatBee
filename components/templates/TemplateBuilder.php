<?php

class TemplateBuilder
{

    private $currentSource;
    private $masterSource;
    private $currentSection;
    private $currentField;

    protected function getCurrentSource()
    {
        return $this->currentSource;
    }

    protected function getCurrentSection()
    {
        return $this->currentSection;
    }

    protected function getCurrentField()
    {
        return $this->currentField;
    }

    protected function buildTemplateHeader($template)
    {
        return "";

    }

    protected function buildTemplateFooter($template)
    {
        return "";

    }

    protected function buildSectionHeader()
    {
        return "";
    }

    protected function buildSectionFooter()
    {
        return "";
    }

    protected function buildFieldHeader()
    {
        return "";
    }

    protected function buildFieldFooter()
    {
        return "";
    }

    public function buildTemplate($data, $template)
    {
        $this->masterSource = $data;
        $this->currentSource = $data;
        $result = $this->buildTemplateHeader($template);

        foreach ($template->sections as $section)
        {
            $result .= $this->buildTemplateSection($data, $section);
        }

        $this->currentSource = $data;
        $result .= $this->buildTemplateFooter($template);

        return $result;

    }

    private function buildTemplateSection($data, $section)
    {
        if (!$section->fields || count($section->fields) == 0)
        {
            return "";
        }

        $source = $this->getSource($data, $section->source);

        if (!$source || count($source) == 0)
        {
            return "";
        }

        $this->currentSection = $section;
        $this->currentSource = $data;

        $result = $this->buildSectionHeader();

        for ($rowNo = 0; $rowNo < count($source); $rowNo++)
        {
            foreach ($section->fields as $field)
            {
                $result .= $this->buildSectionField($source[$rowNo], $field);
            }
        }

        $result .= $this->buildSectionFooter();

        return $result;

    }

    private function extractTags($source)
    {
        $tags = array();
        $b = -1;
        for($i=0; $i<strlen($source); $i++)
        {
            if ($source[$i] == '[')
            {
                $b = $i;
            }
            else if ($source[$i] == ']' && ($b >= 0))
            {
                array_push($tags, substr($source, $b + 1, $i - $b - 1));
                $b = -1;
            }
        }

        return $tags;
    }

    private function buildSectionField($data, $field)
    {
        $this->currentField = $field;
        $this->currentSource = $data;

        $result = $this->buildFieldHeader();

        if ($field->source)
        {
            $fieldValue = $field->source;
            $tags = $this->extractTags($fieldValue);

            foreach ($tags as $tag)
            {
                $value = $this->getSource($data, $tag);
                if (!$value)
                {
                    $value = $this->getSource($this->masterSource, $tag);
                }
                if (!$value)
                {
                    $value ='';
                }
                $fieldValue = str_replace('['.$tag.']', $value, $fieldValue);

            }
            //todo under construction
            $result .= $fieldValue;

        }
        $result .= $this->buildFieldFooter();
        return $result;
    }

    private function getSource($data, $source)
    {
        if (is_numeric($source))
        {
            $loopCnt = intval($source);
            $result = array();
            for ($loopNo = 0; $loopNo < $loopCnt; $loopNo++)
            {
                array_push($result, $data);
            }
            return $result;
        }

        $props = explode(".", $source);

        $result = $data;
        foreach ($props as $prop)
        {
            $result = $result->$prop;
            if (!$result)
            {
                return null;
            }
        }
        return $result;
    }

}
