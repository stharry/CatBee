<?php

class TemplateBuilder
{
    private $currentSource;
    private $masterSource;

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

    public function buildTemplate($data, $template, $decorator)
    {
        RestLogger::log("TemplateBuilder::buildTemplate data: ", $data);

        $this->masterSource = $data;
        $this->currentSource = $data;
        $result = $decorator->decorateTemplateHeader($template);

        foreach ($template->sections as $section)
        {
            $result .= $this->buildTemplateSection($data, $section, $decorator);
        }

        $this->currentSource = $data;
        $result .= $decorator->decorateTemplateFooter($template);

        return $result;

    }

    private function buildTemplateSection($data, $section, $decorator)
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

        $this->currentSource = $data;

        $result = $decorator->decorateSectionHeader($section);

        for ($rowNo = 0; $rowNo < count($source); $rowNo++)
        {
            foreach ($section->fields as $field)
            {
                $result .= $this->buildSectionField($source[$rowNo], $field, $decorator);
            }
        }

        $result .= $decorator->decorateSectionFooter();

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

    private function buildSectionField($data, $field, $decorator)
    {
        $this->currentSource = $data;

        if ($field->source)
        {
            $fieldValue = $this->parseExpression($field->source, $data);
        }
        else
        {
            $fieldValue = '';
        }

        if ($field->linkSource)
        {
            $linkValue = $this->parseExpression($field->linkSource, $data);
        }
        else
        {
            $linkValue = '';
        }

        $result = $decorator->decorateField($field, $fieldValue, $linkValue);

        return $result;
    }

    private function parseExpression($source, $data)
    {
        $fieldValue = $source;
        $tags = $this->extractTags($fieldValue);

        RestLogger::log('------parse Expression: ', $source);

        foreach ($tags as $tag)
        {
            $value = $this->getSource($data, $tag);
            if (!$value)
            {
                $value = $this->getSource($this->masterSource, $tag);
            }
            if (!$value)
            {
                $value = '';
            }
            $fieldValue = str_replace('[' . $tag . ']', $value, $fieldValue);

        }
        return $fieldValue;
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

        RestLogger::log('----getSource props', $props);
        RestLogger::log('------getSource data', $data);

        $result = $data;
        foreach ($props as $prop)
        {
            RestLogger::log('--------getSource ploop', $prop);
            $result = $result->$prop;
            RestLogger::log('--------getSource ploop res', $result);
            if (!$result)
            {
                return null;
            }
        }

        RestLogger::log('--------getSource result', $result);
        return $result;

    }

}
