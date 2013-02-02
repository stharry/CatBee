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
      if (empty($orderIds) || !is_array($orderIds)) {
          return;
      }
      $order = Mage::getModel('sales/order')->load(reset($orderIds));
      $catBeeArray = array(
        'id' => $order->getId(),
        'email' => $order->getCustomerEmail(),
        'name' => $order->getCustomerName(),
        'subTotal' => $order->getGrandTotal() - $order->getShippingAmount(),
      );
      Mage::getSingleton('checkout/session')->setData('catbee', $catBeeArray);
      Mage::log($catBeeArray);
  }
}

