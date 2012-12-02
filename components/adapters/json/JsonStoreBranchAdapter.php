<?php

class JsonStoreBranchAdapter implements IModelAdapter
{
    private function singleBranchFromArray($obj)
    {
        $storeBranch = new StoreBranch();

        $storeBranch->shopId = $obj['shopId'];
        $storeBranch->shopName = $obj['shopName'];
        $storeBranch->url = $obj['url'];
        $storeBranch->logoUrl = $obj['logoUrl'];
        $storeBranch->email = $obj['email'];

        return $storeBranch;
    }

    public function toArray($obj)
    {
        return array(
            'shopId' => $obj->shopId,
            'shopName' => $obj->shopName,
            'url' => $obj->url,
            'email' => $obj->email
        );
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
