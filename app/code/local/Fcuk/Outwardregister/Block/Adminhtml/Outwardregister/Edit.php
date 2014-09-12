<?php

class Fcuk_Outwardregister_Block_Adminhtml_Outwardregister_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'outwardregister';
        $this->_controller = 'adminhtml_outwardregister';
        
        $this->_updateButton('save', 'label', Mage::helper('outwardregister')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('outwardregister')->__('Delete Item'));
		//$this->_removeButton('delete');
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('outwardregister_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'outwardregister_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'outwardregister_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('outwardregister_data') && Mage::registry('outwardregister_data')->getId() ) {
            return Mage::helper('outwardregister')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('outwardregister_data')->getTitle()));
        } else {
            return Mage::helper('outwardregister')->__('Add Item');
        }
    }
}