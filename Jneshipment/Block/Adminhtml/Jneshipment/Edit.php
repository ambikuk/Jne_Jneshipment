<?php

class Jne_Jneshipment_Block_Adminhtml_Jneshipment_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'jneshipment';
        $this->_controller = 'adminhtml_jneshipment';
        
        $this->_updateButton('save', 'label', Mage::helper('jneshipment')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('jneshipment')->__('Delete '));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('jneshipment_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'jneshipment_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'jneshipment_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('jneshipment_data') && Mage::registry('jneshipment_data')->getId() ) {
            return Mage::helper('jneshipment')->__("Edit Tracking AWB '%s'", $this->htmlEscape(Mage::registry('jneshipment_data')->getTitle()));
        } else {
            return Mage::helper('jneshipment')->__('Add Tracking AWB');
        }
    }
}