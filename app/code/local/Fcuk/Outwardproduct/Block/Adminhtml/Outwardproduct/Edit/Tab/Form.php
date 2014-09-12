<?php

class Fcuk_Outwardproduct_Block_Adminhtml_Outwardproduct_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('outwardproduct_form', array('legend'=>Mage::helper('outwardproduct')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('outwardproduct')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('outwardproduct')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('outwardproduct')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('outwardproduct')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('outwardproduct')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('outwardproduct')->__('Content'),
          'title'     => Mage::helper('outwardproduct')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getOutwardproductData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getOutwardproductData());
          Mage::getSingleton('adminhtml/session')->setOutwardproductData(null);
      } elseif ( Mage::registry('outwardproduct_data') ) {
          $form->setValues(Mage::registry('outwardproduct_data')->getData());
      }
      return parent::_prepareForm();
  }
}