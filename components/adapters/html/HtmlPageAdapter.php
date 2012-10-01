<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IPageAdapter.php");

class HtmlPageAdapter implements IPageAdapter
{

    public function loadPage($pageTemplate)
    {
//        $pageTemplate->context = mysql_real_escape_string(file_get_contents($pageTemplate->url));
        $pageTemplate->context = file_get_contents($pageTemplate->url);
    }

    public function savePage($pageTemplate)
    {
        // TODO: Implement savePage() method.
    }
}
