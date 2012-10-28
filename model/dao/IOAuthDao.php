<?php

interface IOAuthDao
{
    public function addApplication($application);

    public function getApplicationByContextId($id);

    public function removeApplicationById($id);
}
