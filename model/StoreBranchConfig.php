<?php

class StoreBranchConfig
{
    public $branch;
    public $widgets;

    public function addWidget()
    {
        if (!$this->widgets)
        {
            $this->widgets = array();
        }
        $widget = new BranchWidget();
        array_push($this->widgets, $widget);

        return $widget;
    }
}
