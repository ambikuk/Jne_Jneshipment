<?php
class Jne_Jneshipment_Block_Adminhtml_Jneshipment extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_jneshipment';
    $this->_blockGroup = 'jneshipment';
		$this->_headerText = Mage::helper('sales')->__('Manage Shipment Order');
//    $this->_headerText = Mage::helper('jneshipment')->__('Tracking AWB Manager');
//    $this->_addButtonLabel = Mage::helper('jneshipment')->__('Add Tracking AWB');
    parent::__construct();
  }
}