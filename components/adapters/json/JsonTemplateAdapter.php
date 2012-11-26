<?php

class JsonTemplateAdapter implements IModelAdapter
{

    private function propsFromArray(&$props, $obj)
    {
        foreach ($obj as $propName => $propValue)
        {
            $props[$propName] = $propValue;
        }
    }

    public function toArray($obj)
    {
        return array(
            "attrs" => $this->propsToArray($obj->style->attributes),
            "style" => $this->propsToArray($obj->style->elements),
            "sections" => $this->sectionsToArray($obj->sections));
    }

    public function fromArray($obj)
    {
        $template = new Template();

        $this->propsFromArray($template->style->elements, $obj["style"]);
        $this->propsFromArray($template->style->attributes, $obj["attrs"]);

        foreach ($obj['sections'] as $section)
        {
            $this->sectionFromArray($template->addSection(), $section);
        }

        return $template;
    }

    private function sectionFromArray($section, $obj)
    {
        $this->propsFromArray($section->style->attributes, $obj['attrs']);
        $this->propsFromArray($section->style->elements, $obj['style']);
        $section->source = $obj['source'];
        $section->condition = $obj['condition'];

        foreach ($obj['fields'] as $field)
        {
            $this->fieldFromArray($section->addField(), $field);
        }
    }

    private function fieldFromArray($field, $obj)
    {
        $this->propsFromArray($field->style->elements, $obj['style']);
        $this->propsFromArray($field->style->attributes, $obj['attrs']);
        $field->source = $obj['source'];
        $field->linkSource = $obj['linkSource'];
        $field->type = $obj['type'];

    }

    private function propsToArray($props)
    {
        $result = array();

        foreach ($props as $propName => $propValue)
        {
            $result[$propName] = $propName;
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
            "attrs" => $this->propsToArray($section->style->attributes),
            "style" => $this->propsToArray($section->style->elements),
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
                "attrs" => $this->propsToArray($field->style->attributes),
                "style" => $this->propsToArray($field->style->elements),
                "source" => $field->source,
                "type" => $field->type
            );

            array_push($result, $fieldProps);
        }
        return $result;
    }
}
