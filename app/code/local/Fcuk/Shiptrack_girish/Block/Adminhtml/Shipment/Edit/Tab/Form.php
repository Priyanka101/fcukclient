<?php
class Fcuk_Shiptrack_Block_Adminhtml_Shipment_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("shiptrack_form", array("legend"=>Mage::helper("shiptrack")->__("Item information")));

				
						$fieldset->addField("awbnumber", "text", array(
						"label" => Mage::helper("shiptrack")->__("awbnumber"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "awbnumber",
						));
					
						$fieldset->addField("carrier", "text", array(
						"label" => Mage::helper("shiptrack")->__("carrier"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "carrier",
						));
					
						$fieldset->addField("status", "text", array(
						"label" => Mage::helper("shiptrack")->__("status"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "status",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getShipmentData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getShipmentData());
					Mage::getSingleton("adminhtml/session")->setShipmentData(null);
				} 
				elseif(Mage::registry("shipment_data")) {
				    $form->setValues(Mage::registry("shipment_data")->getData());
				}
				return parent::_prepareForm();
		}
}
