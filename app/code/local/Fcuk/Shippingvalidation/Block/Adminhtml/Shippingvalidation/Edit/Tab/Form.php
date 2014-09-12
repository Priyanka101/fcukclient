<?php

class Fcuk_Shippingvalidation_Block_Adminhtml_Shippingvalidation_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('shippingvalidation_form', array('legend'=>Mage::helper('shippingvalidation')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('shippingvalidation')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));


		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('shippingvalidation')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('shippingvalidation')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('shippingvalidation')->__('Disabled'),
              ),
          ),
      ));

           $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('shippingvalidation')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
      if ( Mage::getSingleton('adminhtml/session')->getShippingvalidationData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getShippingvalidationData());
          Mage::getSingleton('adminhtml/session')->setShippingvalidationData(null);
      } elseif ( Mage::registry('shippingvalidation_data') ) {
          $form->setValues(Mage::registry('shippingvalidation_data')->getData());
      }
      return parent::_prepareForm();
  }
}