<?php
class Addons_Storelocator_Block_Adminhtml_Storelocator_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("store_form", array("legend"=>Mage::helper("storelocator")->__("Store information")));

				$fieldset->addField("name", "text", array(
					"label" => Mage::helper("storelocator")->__("Store Name"),
					"name" => "name",
				));
				
				$fieldset->addField("address", "textarea", array(
					"label" => Mage::helper("storelocator")->__("Address"),
					"class" => "required-entry",
					"required" => true,
					"name" => "address",
				));
				
				$fieldset->addField("landmark", "text", array(
					"label" => Mage::helper("storelocator")->__("Google Map Locator"),
					
					"name" => "landmark",
				));
				
				$fieldset->addField("area", "text", array(
					"label" => Mage::helper("storelocator")->__("Area"),
					
					"name" => "area",
				));
				
				$fieldset->addField("city", "text", array(
					"label" => Mage::helper("storelocator")->__("City"),
					"class" => "required-entry",
					"required" => true,
					"name" => "city",
				));
				/*$fieldset->addField("state", "text", array(
					"label" => Mage::helper("storelocator")->__("State"),
					"class" => "required-entry",
					"required" => true,
					"name" => "state",
				));
				$fieldset->addField("zip", "text", array(
					"label" => Mage::helper("storelocator")->__("Zip Code"),
					"class" => "required-entry validate-number",
					"required" => true,
					"name" => "zip",
				));
				
				$fieldset->addField("contact_person", "text", array(
					"label" => Mage::helper("storelocator")->__("Contact Person"),
					//"class" => "required-entry ",
					"required" => false,
					"name" => "contact_person",
				));*/
				
				$fieldset->addField("phone", "text", array(
					"label" => Mage::helper("storelocator")->__("Phone No."),
					"class" => "required-entry ",
					"required" => true,
					"name" => "phone",
				));
			
				$fieldset->addField("email", "text", array(
					"label" => Mage::helper("storelocator")->__("Email"),
					//"class" => "required-entry ",
					"required" => false,
					"name" => "email",
					"validate"=>"validate-email",
				));
				$fieldset->addField("gender", "select", array(
					"label" => Mage::helper("storelocator")->__("Gender"),
					"required" => true,
					"name" => "gender",
					"values" => array('1'=>"Women",'0'=>"Men")
				));

		      

				if (Mage::getSingleton("adminhtml/session")->getStorelocatorData()){
					$form->setValues(Mage::getSingleton("adminhtml/session")->getStorelocatorData());
					Mage::getSingleton("adminhtml/session")->setStorelocatorData(null);
				} 
				elseif(Mage::registry("storelocator_data")) {
				    $form->setValues(Mage::registry("storelocator_data")->getData());
				}
				return parent::_prepareForm();
		}
}
