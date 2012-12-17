<?php

interface IStoreBranchDao
{
    public function isStoreBranchExists($branch);

    public function loadBranchById($branch);

    public function addStoreBranch($branch);

    public function getStoreBranches($store);
}
