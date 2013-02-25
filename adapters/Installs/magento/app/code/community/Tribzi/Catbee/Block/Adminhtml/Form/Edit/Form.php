<?php
/**
 * Class Tribzi_Catbee_Block_Adminhtml_Catbee_Form
 * @author  Yaniv Aran-Shamir
 */
class Tribzi_Catbee_Block_Adminhtml_Form_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct($options)
    {
        parent::__construct();

        $this->_objectId   = 'id';
        $this->_blockGroup = 'Tribzi_Catbee';
        $this->_controller = 'adminhtml_form';
        $this->_headerText = Mage::helper('Tribzi_Catbee')->__('Edit Form');
    }

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(
            array(
                'id'     => 'edit_form',
                'action' => $this->getUrl('*/*/save'),
                'method' => 'post',
            )
        );

        $form->setUseContainer(true);
        $this->setForm($form);

        $helper   = Mage::helper('Tribzi_Catbee');
        $fieldset = $form->addFieldset('display', array(
            'legend' => $helper->__('Global Configuration'),
            'class'  => 'fieldset-wide'
        ));

        $fieldset->addField('storeId', 'text', array(
            'name'  => 'Store Id',
            'label' => $helper->__('Tribzi store id'),
        ));
        $fieldset->addField('adpterId', 'text', array(
            'name'  => 'Adpter Id',
            'label' => $helper->__('Tribzi adapter id'),
        ));
        $fieldset->addField('apiServer', 'text', array(
            'name'  => 'api Server',
            'label' => $helper->__('api url'),
        ));

        $fieldset3 = $form->addFieldset('display3', array(
            'legend' => $helper->__('Campaign coupons'),
            'class'  => 'fieldset-wide'
        ));

        $fieldset3->addField('campaign', 'select', array(
            'name'   => 'campaign',
            'label'  => $helper->__('Tribzi campaigns'),
            'values' => $helper->getCampaigns(),
        ));

        Mage::log($helper->getStoreConfig('Store_Id'));
        $form->setValues(array(
                             'storeId' => $helper->getStoreConfig('Store_Id'),
                             'adpterId' => $helper->getStoreConfig('Adpter_Id'),
                             'apiServer' => $helper->getStoreConfig('api_Server')
                         ));

        return parent::_prepareForm();
    }
}

