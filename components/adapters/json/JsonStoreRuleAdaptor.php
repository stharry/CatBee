<?php

class JsonStoreRuleAdaptor implements IModelAdapter
{

    private function singleRuleFromArray($obj)
    {
        $storeRule = new StoreRule();
        $storeRule->id = $obj['id'];
        $storeRule->actionTriger = $obj['actionTriger'];
        $storeRule->description = $obj['description'];
        $storeRule->name = $obj['name'];
        $storeRule->ruleReward = $obj['reward'];
        $storeRule->type = $obj['type'];
        return $storeRule;
    }

    public function toArray($obj)
    {
        if (is_array($obj))
        {
            $rules= array();

            foreach ($obj as $store)
            {
                array_push($rules, $this->singleRuleToArray($store));
            }
            return $rules;
        }
        else
        {
            return $this->singleRuleToArray($obj);
        }
    }
    private function singleRuleToArray($rule)
    {
        return array("id" => $rule->id,
            "actionTriger" => $rule->actionTriger,
            "description" => $rule->description,
            "name" => $rule->name,
            "ruleReward" => $rule->ruleReward,
            "type" => $rule->type
        );
    }

    public function fromArray($obj)
    {
        if ($obj === array_values($obj))
        {
            $rules = array();
            foreach ($obj as $rule)
            {
                array_push($rules, $this->singleRuleFromArray($rule));

            }

            return $rules;
        }
        return $this->singleRuleFromArray($obj);
    }
}
