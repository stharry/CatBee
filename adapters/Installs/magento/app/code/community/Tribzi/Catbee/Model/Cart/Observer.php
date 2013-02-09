<?php
/**
 * Class Tribzi_Catbee_Model_Cart_Observer
 * @author  Yaniv Aran-Shamir
 */
class Tribzi_Catbee_Model_Cart_Observer
{
    public function addCatbee(Varien_Event_Observer $observer)
    {
        $orderIds = $observer->getEvent()->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds))
        {
            return;
        }
        $order       = Mage::getModel('sales/order')->load(reset($orderIds));
        $data        = $order->getData();
        $items       = $order->getAllItems();
        $fistItem    = reset($items);
        $prod        = Mage::getModel('catalog/product')->load($fistItem->getProductId());
        $catBeeArray = array(
            'id'    => $order->getId(),
            'ce'    => $order->getCustomerEmail(),
            'cn'    => $order->getCustomerName(),
            'ot'    => $data[ 'subtotal' ],
            'icnt'  => 1, //count($items),
            'i0upc' => $prod->getSku(),
            'i0url' => Mage::getModel('catalog/product_media_config')->getMediaUrl($prod->getImage()),
            'shop'  => 2, //Mage::getStoreConfig('tribzi/tribziGlobal/shopId'),
            'adpt'  => '54c5e6c3-6349-11e2-a702-0008cae720a7' //Mage::getStoreConfig('tribzi/tribziGlobal/adapterId'),
        );
        Mage::getSingleton('checkout/session')->setData('catbee', $catBeeArray);
    }
}
