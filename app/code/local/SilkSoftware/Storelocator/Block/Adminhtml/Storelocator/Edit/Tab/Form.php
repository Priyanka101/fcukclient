<?php
class SilkSoftware_Storelocator_Block_Adminhtml_Storelocator_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("storelocator_form", array("legend"=>Mage::helper("storelocator")->__("Item information")));


						$fieldset->addField("store", "editor", array(
						"label" => Mage::helper("storelocator")->__("Store"),
						"name" => "store",
						"style" => "width:500px; height:100px;",
						"config"   => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
						"wysiwyg"    => true,
						));

						$fieldset->addField("address", "editor", array(
						"label" => Mage::helper("storelocator")->__("Address"),
						"name" => "address",
						"style" => "width:500px; height:300px;",
						"config"    => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
						"wysiwyg"   => true,
						));

						$fieldset->addField("city", "text", array(
						"label" => Mage::helper("storelocator")->__("City"),
						"name" => "city",
						));

						$fieldset->addField("pincode", "text", array(
						"label" => Mage::helper("storelocator")->__("pin code"),
						"name" => "pincode",
						));

						$fieldset->addField("tel_number", "text", array(
						"label" => Mage::helper("storelocator")->__("telephone number"),
						"name" => "tel_number",
						));


						$fieldset->addField('exclusive', 'select', array(
						  'label'     => Mage::helper('storelocator')->__('Exclusive'),
						  'name'      => 'exclusive',
						  'values' => array('0' => 'No','1' => 'Yes'),
						  'disabled' => false,
						  'readonly' => false,
						  'after_element_html' => '<br/>if store is exclusive store select yes',
						  'tabindex' => 1
						));

						$fieldset->addField('country_name', 'select', array(
						  'label'     => Mage::helper('storelocator')->__('Country Name'),
						  'name'      => 'country_name',
						  // 'values' => array('0' => 'No','1' => 'Yes'),
						  'values'   => SilkSoftware_Storelocator_Block_Adminhtml_Storelocator_Grid::getValueArray2(),
						  'disabled' => false,
						  'readonly' => false,
						  'after_element_html' => '<br/>Select country name',
						  'tabindex' => 1
						));

						$fieldset->addField('is_opening_soon', 'select', array(
						  'label'     => Mage::helper('storelocator')->__('Coming Soon'),
						  'name'      => 'is_opening_soon',
						  'values' => array('0' => 'No','1' => 'Yes'),
						  'disabled' => false,
						  'readonly' => false,
						  'after_element_html' => '<br/>Select 1 is Opening Soon',
						  'tabindex' => 1
						));


						/* $fieldset->addField('exclusive', 'select', array(
				          'label'     => Mage::helper('storelocator')->__('Select'),
				          'onclick' => "",
				          'onchange' => "",
				          'value'  => '1',
				          'values' => array('-1'=>'Please Select..','0' => 'No','1' => 'Yes'),
				          'tabindex' => 1
				        )); */

						$fieldset->addField("order", "text", array(
						"label" => Mage::helper("storelocator")->__("Order"),
						"name" => "order",
						));


				if (Mage::getSingleton("adminhtml/session")->getStorelocatorData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getStorelocatorData());
					Mage::getSingleton("adminhtml/session")->setStorelocatorData(null);
				}
				elseif(Mage::registry("storelocator_data")) {
				    $form->setValues(Mage::registry("storelocator_data")->getData());
				}
				return parent::_prepareForm();
		}
}
