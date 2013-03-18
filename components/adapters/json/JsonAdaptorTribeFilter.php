<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Tomerh
 * Date: 3/7/13
 * Time: 2:58 PM
 * To change this template use File | Settings | File Templates.
 */
class JsonAdaptorTribeFilter implements IModelAdapter
{
    private $customerAdapter;
    function __construct()
    {
        $this->customerAdapter = new JsonCustomerAdapter();

    }
    public function toArray($obj)
    {
    }

    public function fromArray($obj)
    {
        $TribeFilter = new TribeFilter();
        $TribeFilter->customers = $this->customerAdapter->fromArray($obj["Customer"]);
        return $TribeFilter;
    }

}
