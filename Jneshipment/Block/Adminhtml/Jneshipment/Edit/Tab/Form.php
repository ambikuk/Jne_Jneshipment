<?php

class Jne_Jneshipment_Block_Adminhtml_Jneshipment_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('jneshipment_form', array('legend'=>Mage::helper('jneshipment')->__('General information')));
			
			$fieldset->addField('order_id', 'text', array(
          'label'     => Mage::helper('jneshipment')->__('Order ID'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'order_id',
      ));
			
			
			$fieldset->addField('awb', 'text', array(
          'label'     => Mage::helper('jneshipment')->__('Tracking Awb'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'awb',
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getJneshipmentData() )
      {
          $data = Mage::getSingleton('adminhtml/session')->getJneshipmentData();
          Mage::getSingleton('adminhtml/session')->setJneshipmentData(null);
      } elseif ( Mage::registry('jneshipment_data') ) {
          $data = Mage::registry('jneshipment_data')->getData();
      }
	  $data['store_id'] = explode(',',$data['stores']);
	  $form->setValues($data);
	  
      return parent::_prepareForm();
  }
}