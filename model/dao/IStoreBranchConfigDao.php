<?php

interface IStoreBranchConfigDao
{
    public function getBranchConfig($configFilter);

    public function setBranchConfig($branchConfig);
}
