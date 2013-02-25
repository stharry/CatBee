<?php

class PdoStoreBranchConfigDao implements IStoreBranchConfigDao
{
    public function isConfigExists($configFilter)
    {
        $select = "SELECT widgetId, widgetParams FROM shopWidgets w
        INNER JOIN StoreBranch s ON w.branchId = s.id WHERE s.shopId=? ";

        $params = array(new DbParameter($configFilter->shopId, PDO::PARAM_INT));

        if ($configFilter->widgetId)
        {
            $select .= " AND w.widgetId=?";
            $params[] = new DbParameter($configFilter->widgetId, PDO::PARAM_INT);
        }

        $rows = DbManager::selectValues($select, $params);

        return $rows && (count($rows) > 0);
    }

    public function getBranchConfig($configFilter)
    {
        $select = "SELECT widgetId, widgetParams FROM shopWidgets w
        INNER JOIN StoreBranch s ON w.branchId = s.id WHERE s.shopId=? ";

        $params = array(new DbParameter($configFilter->shopId, PDO::PARAM_INT));

        if ($configFilter->widgetId)
        {
            $select .= " AND w.widgetId=?";
            $params[] = new DbParameter($configFilter->widgetId, PDO::PARAM_INT);
        }

        $rows = DbManager::selectValues($select, $params);

        $config = new StoreBranchConfig();
        foreach ($rows as $row)
        {
            $widget      = $config->addWidget();
            $widget->id  = $row['widgetId'];
            $widget->gui = json_decode($row['widgetParams'], true);

        }

        return $config;
    }

    public function setBranchConfig($branchConfig)
    {
        $configFilter = new StoreBranchConfigFilter();
        $configFilter->shopId = $branchConfig->branch->shopId;

        foreach ($branchConfig->widgets as $widget)
        {
            $configFilter->widgetId = $widget->id;

            if (!$this->isConfigExists($configFilter))
            {
                $fields = array("branchId", "widgetId", "widgetParams");
                $values = array($branchConfig->branch->id, $widget->id, json_encode($widget->gui));
                DbManager::insertOnly("shopWidgets", $fields, $values);
            }
            else
            {
                $update = "UPDATE shopWidgets set widgetParams=:widgetParams WHERE
                    branchId=:branchId AND widgetId=:widgetId";
                $params = array(
                    ':widgetParams' => json_encode($widget->gui),
                    ':branchId' => $branchConfig->branch->id,
                    ':widgetId' => $widget->id
                );
                DbManager::updateValues($update, $params);

            }
        }
    }
}
