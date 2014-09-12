<?php

class Fcuk_Shippingvalidation_Block_Adminhtml_Shippingvalidation_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'shippingvalidation';
        $this->_controller = 'adminhtml_shippingvalidation';
        
        $this->_updateButton('save', 'label', Mage::helper('shippingvalidation')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('shippingvalidation')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('shippingvalidation_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'shippingvalidation_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'shippingvalidation_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('shippingvalidation_data') && Mage::registry('shippingvalidation_data')->getId() ) {
            return Mage::helper('shippingvalidation')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('shippingvalidation_data')->getTitle()));
        } else {
            return Mage::helper('shippingvalidation')->__('Add Item');
        }
    }
}