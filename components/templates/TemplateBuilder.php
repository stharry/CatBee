<?php

class TemplateBuilder
{
    private $currentSource;
    private $masterSource;
    private $lineBreak;

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
        //RestLogger::log("TemplateBuilder::buildTemplate data: ", $data);

        $this->masterSource = $data;
        $this->currentSource = $data;
        $this->lineBreak = $decorator->getLineBreak();

        $result = $decorator->decorateTemplateHeader($template);

        foreach ($template->fields as $field)
        {
            $result .= $this->buildTemplateFieldLoop($data, $field, $decorator);
        }

        $this->currentSource = $data;
        $result .= $decorator->decorateTemplateFooter($template);

        return $result;

    }

    private function buildTemplateFieldLoop($data, $field, $decorator)
    {
        $result = '';

        //todo RestLogger::log('--Field loop: ', $field->loop);

        $loop = isset($field->loop) ? $field->loop : "1";
        $source = $this->getSource($data, $loop);

        if (!$source || count($source) == 0)
        {
            return $result;
        }

        $this->currentSource = $data;

        for ($rowNo = 0; $rowNo < count($source); $rowNo++)
        {
            $result .= $this->buildTemplateField($source[$rowNo], $field, $decorator);
        }


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

    private function buildTemplateField($data, $field, $decorator)
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

        $result = $decorator->decorateFieldHeader($field, $fieldValue, $linkValue);

        $result .= $decorator->decorateField($field, $fieldValue, $linkValue);

        foreach ($field->childFields as $childField)
        {
            $result .= $this->buildTemplateFieldLoop($data, $childField, $decorator);
        }


        $result .= $decorator->decorateFieldFooter($field, $fieldValue, $linkValue);


        return $result;
    }

    private function parseExpression($source, $data)
    {
        $fieldValue = $source;
        $tags = $this->extractTags($fieldValue);

        //todo RestLogger::log('------parse Expression: ', $source);

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
        return str_replace('{lb}', $this->lineBreak, $fieldValue);
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

        //todo RestLogger::log('----getSource props', $props);
        //todo RestLogger::log('------getSource data', $data);

        $result = $data;
        foreach ($props as $prop)
        {
            //todo RestLogger::log('--------getSource ploop', $prop);
            $result = $result->$prop;
            //todo RestLogger::log('--------getSource ploop res', $result);
            if (!$result)
            {
                //todo RestLogger::log('--------getSource result is NULL');
                return null;
            }
        }

        //todo RestLogger::log('--------getSource result', $result);
        return $result;

    }

}
