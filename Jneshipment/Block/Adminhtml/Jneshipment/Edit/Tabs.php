<?php

class Jne_Jneshipment_Block_Adminhtml_Jneshipment_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('jneshipment_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('jneshipment')->__('Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('jneshipment')->__('General Information'),
          'title'     => Mage::helper('jneshipment')->__('General Information'),
          'content'   => $this->getLayout()->createBlock('jneshipment/adminhtml_jneshipment_edit_tab_form')->toHtml(),
      ));
	  
//	  $this->addTab('display_section',array(
//			'label'		=> Mage::helper('jneshipment')->__('Categories'),
//			'url'       => $this->getUrl('*/*/categories', array('_current' => true)),
//            'class'     => 'ajax',
//	  ));
     
      return parent::_beforeToHtml();
  }
}