<?php

class JsonTemplateAdapter implements IModelAdapter
{

    private function styleFromArray($style, $obj)
    {
        foreach ($obj as $styleElemName => $styleElemValue)
        {
            $style->elements[$styleElemName] = $styleElemValue;
        }
        return $style;
    }

    public function toArray($obj)
    {
        return array(
            "width" => $obj->width,
            "style" => $this->styleToArray($obj->style),
            "sections" => $this->sectionsToArray($obj->sections));
    }

    public function fromArray($obj)
    {
        $template = new Template();

        $template->width = $obj['width'];
        $this->styleFromArray($template->style, $obj["style"]);

        foreach ($obj['sections'] as $section)
        {
            $this->sectionFromArray($template->addSection(), $section);
        }

        return $template;
    }

    private function sectionFromArray($section, $obj)
    {
        $this->styleFromArray($section->style, $obj['style']);
        $section->source = $obj['source'];
        $section->condition = $obj['condition'];

        foreach ($obj['fields'] as $field)
        {
            $this->fieldFromArray($section->addField(), $field);
        }
    }

    private function fieldFromArray($field, $obj)
    {
        $this->styleFromArray($field->style, $obj['style']);
        $field->source = $obj['source'];
        $field->type = $obj['type'];

    }

    private function styleToArray($style)
    {
        $result = array();

        foreach ($style->elements as $elemName => $elemValue)
        {
            $result[$elemName] = $elemValue;
        }

        return $result;
    }

    private function sectionsToArray($sections)
    {
        $result = array();

        foreach ($sections as $section)
        {
            array_push($result, $this->sectionToArray($section));
        }

        return $result;
    }

    private function sectionToArray($section)
    {
        $result = array(
            "style" => $this->styleToArray($section->style),
            "source" => $section->source,
            "condition" => $section->condition,
            "fields" => $this->fieldsToArray($section->fields)
        );

        return $result;
    }

    private function fieldsToArray($fields)
    {
        $result = array();

        foreach ($fields as $field)
        {
            $fieldProps = array(
                "style" => $this->styleToArray($field->style),
                "source" => $field->source,
                "type" => $field->type
            );

            array_push($result, $fieldProps);
        }
        return $result;
    }
}
