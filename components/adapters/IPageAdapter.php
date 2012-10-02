<?php

interface IPageAdapter
{
    public function loadPage($pageTemplate);

    public function savePage($pageTemplate);
}
