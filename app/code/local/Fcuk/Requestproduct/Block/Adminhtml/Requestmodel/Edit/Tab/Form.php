<?php
class Fcuk_Requestproduct_Block_Adminhtml_Requestmodel_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("requestproduct_form", array("legend"=>Mage::helper("requestproduct")->__("Item information")));

				
						$fieldset->addField("requestproduct_id", "text", array(
						"label" => Mage::helper("requestproduct")->__("ID"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "requestproduct_id",
						));
					
						$fieldset->addField("firstname", "text", array(
						"label" => Mage::helper("requestproduct")->__("First Name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "firstname",
						));
						
						$fieldset->addField("lastname", "text", array(
						"label" => Mage::helper("requestproduct")->__("Last Name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "lastname",
						));
						
						$fieldset->addField("address", "text", array(
						"label" => Mage::helper("requestproduct")->__("Address"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "address",
						));
						
						$fieldset->addField("city", "text", array(
						"label" => Mage::helper("requestproduct")->__("City"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "city",
						));
						
						
					
						$fieldset->addField("email", "text", array(
						"label" => Mage::helper("requestproduct")->__("Email"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "email",
						));
					
						$fieldset->addField("phoneno", "text", array(
						"label" => Mage::helper("requestproduct")->__("Phoneno"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "phoneno",
						));
					
						$fieldset->addField("stylecode", "text", array(
						"label" => Mage::helper("requestproduct")->__("Style Code"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "stylecode",
						));
								$fieldset->addField("size", "text", array(
						"label" => Mage::helper("requestproduct")->__("Size"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "size",
						));
						
						$fieldset->addField("color", "text", array(
						"label" => Mage::helper("requestproduct")->__("Color"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "color",
						));
						

				if (Mage::getSingleton("adminhtml/session")->getRequestmodelData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getRequestmodelData());
					Mage::getSingleton("adminhtml/session")->setRequestmodelData(null);
				} 
				elseif(Mage::registry("requestmodel_data")) {
				    $form->setValues(Mage::registry("requestmodel_data")->getData());
				}
				return parent::_prepareForm();
		}
}
