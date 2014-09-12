<?php

class Fcuk_Inwardregister_Block_Adminhtml_Inwardregister_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'inwardregister';
        $this->_controller = 'adminhtml_inwardregister';
        
        $this->_updateButton('save', 'label', Mage::helper('inwardregister')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('inwardregister')->__('Delete Item'));
		//$this->_removeButton('delete');
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('inwardregister_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'inwardregister_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'inwardregister_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('inwardregister_data') && Mage::registry('inwardregister_data')->getId() ) {
            return Mage::helper('inwardregister')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('inwardregister_data')->getTitle()));
        } else {
            return Mage::helper('inwardregister')->__('Add Item');
        }
    }
}