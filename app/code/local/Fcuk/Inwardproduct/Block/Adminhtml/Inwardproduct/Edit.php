<?php

class Fcuk_Inwardproduct_Block_Adminhtml_Inwardproduct_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'inwardproduct';
        $this->_controller = 'adminhtml_inwardproduct';
        
        $this->_updateButton('save', 'label', Mage::helper('inwardproduct')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('inwardproduct')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('inwardproduct_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'inwardproduct_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'inwardproduct_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('inwardproduct_data') && Mage::registry('inwardproduct_data')->getId() ) {
            return Mage::helper('inwardproduct')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('inwardproduct_data')->getTitle()));
        } else {
            return Mage::helper('inwardproduct')->__('Add Item');
        }
    }
}