<?php

includeModel('StoreBranch');
IncludeComponent('adapters', 'IModelAdapter');

class JsonStoreBranchAdapter implements IModelAdapter
{
    private function singleBranchFromArray($obj)
    {
        $storeBranch = new StoreBranch();

        $storeBranch->shopId = $obj['shopId'];
        $storeBranch->shopName = $obj['shopName'];

        return $storeBranch;
    }

    public function toArray($obj)
    {
        return array('shopId' => $obj->shopId, 'shopName' => $obj->shopName );
    }

    public function fromArray($obj)
    {
        if ($obj === array_values($obj))
        {
            $branches = array();
            foreach ($obj as $branch)
            {
                array_push($branches, $this->singleBranchFromArray($branch));

            }
            return $branches;
        }
        return $this->singleBranchFromArray($obj);
    }
}
