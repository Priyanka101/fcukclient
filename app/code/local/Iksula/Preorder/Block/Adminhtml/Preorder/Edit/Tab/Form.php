<?php
class Iksula_Preorder_Block_Adminhtml_Preorder_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("preorder_form", array("legend"=>Mage::helper("preorder")->__("Item information")));

				
						$fieldset->addField("customer_firstname", "text", array(
						"label" => Mage::helper("preorder")->__("First Name"),
						"name" => "customer_firstname",
						));
					
						$fieldset->addField("customer_lastname", "text", array(
						"label" => Mage::helper("preorder")->__("Last Name"),
						"name" => "customer_lastname",
						));
					
						$fieldset->addField("customer_address", "text", array(
						"label" => Mage::helper("preorder")->__("Address"),
						"name" => "customer_address",
						));
					
						$fieldset->addField("customer_email", "text", array(
						"label" => Mage::helper("preorder")->__("Email"),
						"name" => "customer_email",
						));
					
						$fieldset->addField("product_name", "text", array(
						"label" => Mage::helper("preorder")->__("Product Name"),
						"name" => "product_name",
						));
					
						$fieldset->addField("product_sku", "text", array(
						"label" => Mage::helper("preorder")->__("Product Sku"),
						"name" => "product_sku",
						));
					
						$fieldset->addField("selected_size", "text", array(
						"label" => Mage::helper("preorder")->__("Selected Size"),
						"name" => "selected_size",
						));
					
						$fieldset->addField("selected_color", "text", array(
						"label" => Mage::helper("preorder")->__("Selected Color"),
						"name" => "selected_color",
						));
					
						$fieldset->addField("customer_city", "text", array(
						"label" => Mage::helper("preorder")->__("City"),
						"name" => "customer_city",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getPreorderData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getPreorderData());
					Mage::getSingleton("adminhtml/session")->setPreorderData(null);
				} 
				elseif(Mage::registry("preorder_data")) {
				    $form->setValues(Mage::registry("preorder_data")->getData());
				}
				return parent::_prepareForm();
		}
}
