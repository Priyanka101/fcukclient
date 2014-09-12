<?php

class Fcuk_Outwardproduct_Block_Adminhtml_Outwardproduct_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'outwardproduct';
        $this->_controller = 'adminhtml_outwardproduct';
        
        $this->_updateButton('save', 'label', Mage::helper('outwardproduct')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('outwardproduct')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('outwardproduct_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'outwardproduct_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'outwardproduct_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('outwardproduct_data') && Mage::registry('outwardproduct_data')->getId() ) {
            return Mage::helper('outwardproduct')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('outwardproduct_data')->getTitle()));
        } else {
            return Mage::helper('outwardproduct')->__('Add Item');
        }
    }
}