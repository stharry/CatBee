<?php

class JsonRestrictionsAdapter implements IModelAdapter
{
    private function oneRestrictionsFromArray($restProps)
    {
        $restriction = new CampaignRestriction();

        $restriction->name        = $restProps['name'];
        $restriction->description = $restProps['desc'];
        $restriction->expression  = $restProps['expr'];

        return $restriction;
    }

    private function oneRestrictionToArray($restriction)
    {
        return array(
            'name' => $restriction->name,
            'desc' => $restriction->description,
            'expr' => $restriction->expression
        );
    }

    public function toArray($obj)
    {
        $result = array();

        foreach ($obj as $restriction)
        {
            array_push($result, $this->oneRestrictionToArray($restriction));
        }

        return $result;
    }

    public function fromArray($obj)
    {
        if (!isset($obj) || (count($obj) == 0))
        {
            return null;
        }

        $restrictions = array();

        foreach ($obj as $restProps)
        {
            array_push($restrictions, $this->oneRestrictionsFromArray($restProps));
        }

        return $restrictions;
    }

}
