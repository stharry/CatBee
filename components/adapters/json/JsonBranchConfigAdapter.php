<?php

class JsonBranchConfigAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        $result = array();
        foreach ($obj->widgets as $widget)
        {
            array_push($result, array('id' => $widget->id, 'gui' => $widget->gui));
        }

        return $result;
    }

    public function fromArray($obj)
    {
        $branchAdapter = new JsonStoreBranchAdapter();

        $branchConfig = new StoreBranchConfig();

        $branchConfig->branch = $branchAdapter->fromArray($obj['branch']);

        foreach ($obj['widgets'] as $widgetProps)
        {
            $widget      = $branchConfig->addWidget();
            $widget->id  = $widgetProps['id'];
            $widget->gui = $widgetProps['gui'];

        }

        return $branchConfig;
    }
}
