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

    private function style2Array(&$props, $style)
    {
        if (!isset($style)) return;

        if (isset($style->attributes) && (count($style->attributes) > 0))
        {
            $props['attrs'] = $this->propsToArray($style->attributes);
        }
        if (isset($style->elements) && (count($style->elements) > 0))
        {
            $props['style'] = $this->propsToArray($style->elements);
        }
    }

    public function toArray($obj)
    {
        $props = array();

        $this->style2Array($props, $obj->style);
        $props['fields'] = $this->fieldsToArray($obj->fields);

        return $props;
    }

    public function fromArray($obj)
    {
        $template = new Template();

        $this->propsFromArray($template->style->elements, $obj["style"]);
        $this->propsFromArray($template->style->attributes, $obj["attrs"]);

        foreach ($obj['fields'] as $field)
        {
            $this->fieldFromArray($template->addField(), $field);
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
        $field->loop = $obj['loop'];
        $field->linkSource = $obj['linkSource'];
        $field->type = $obj['type'];
        $field->name = $obj['name'];

        if (isset($obj['children']))
        {
            $field->childFields = array();

            foreach ($obj['children'] as $childField)
            {
                $this->fieldFromArray($field->addChild(), $childField);
            }
        }

    }

    private function propsToArray($props)
    {
        $result = array();

        foreach ($props as $propName => $propValue)
        {
            $result[$propName] = $propValue;
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
        $result = array();

        $this->style2Array($result, $section->style);
        $result['source'] = $section->source;
        $result['condition'] = $section->condition;
        $result['fields'] = $this->fieldsToArray($section->fields);

        return $result;
    }

    private function fieldsToArray($fields)
    {
        $result = array();

        foreach ($fields as $field)
        {
            $fieldProps = array();

            $this->style2Array($fieldProps, $field->style);

            if (isset($field->source)) $fieldProps['source'] = $field->source;
            if (isset($field->linkSource)) $fieldProps['linkSource'] = $field->linkSource;
            if (isset($field->type)) $fieldProps['type'] = $field->type;
            if (isset($field->name)) $fieldProps['name'] = $field->name;
            if (isset($field->loop)) $fieldProps['loop'] = $field->loop;

            if (isset($field->childFields) &&
                (count($field->childFields) > 0))
            {
                $fieldProps['children'] =
                    $this->fieldsToArray($field->childFields);
            }

            array_push($result, $fieldProps);
        }
        return $result;
    }
}
