<?php
class Mac_Requestcatalog_Block_Adminhtml_Requestcatalog_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("requestcatalog_form", array("legend"=>Mage::helper("requestcatalog")->__("Item information")));

								
						 $fieldset->addField('title', 'select', array(
						'label'     => Mage::helper('requestcatalog')->__('Title'),
						'values'   => Mac_Requestcatalog_Block_Adminhtml_Requestcatalog_Grid::getValueArray1(),
						'name' => 'title',
						));
						$fieldset->addField("firstname", "text", array(
						"label" => Mage::helper("requestcatalog")->__("First Name"),
						"name" => "firstname",
						));
					
						$fieldset->addField("lastname", "text", array(
						"label" => Mage::helper("requestcatalog")->__("Last Name"),
						"name" => "lastname",
						));
					
						$fieldset->addField("email", "text", array(
						"label" => Mage::helper("requestcatalog")->__("Email"),
						"name" => "email",
						));
					
						$fieldset->addField("address", "textarea", array(
						"label" => Mage::helper("requestcatalog")->__("Address"),
						"name" => "address",
						));
					
						$fieldset->addField("city", "text", array(
						"label" => Mage::helper("requestcatalog")->__("City"),
						"name" => "city",
						));
					
						$fieldset->addField("postcode", "text", array(
						"label" => Mage::helper("requestcatalog")->__("Postcode"),
						"name" => "postcode",
						));
					
						$fieldset->addField("state", "text", array(
						"label" => Mage::helper("requestcatalog")->__("State"),
						"name" => "state",
						));
					
						$fieldset->addField("country", "text", array(
						"label" => Mage::helper("requestcatalog")->__("Country"),
						"name" => "country",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getRequestcatalogData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getRequestcatalogData());
					Mage::getSingleton("adminhtml/session")->setRequestcatalogData(null);
				} 
				elseif(Mage::registry("requestcatalog_data")) {
				    $form->setValues(Mage::registry("requestcatalog_data")->getData());
				}
				return parent::_prepareForm();
		}
}
