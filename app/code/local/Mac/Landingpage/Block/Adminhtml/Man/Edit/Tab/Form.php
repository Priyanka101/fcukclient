<?php
class Mac_Landingpage_Block_Adminhtml_Man_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("landingpage_form", array("legend"=>Mage::helper("landingpage")->__("Item information")));

				
						$fieldset->addField("name", "text", array(
						"label" => Mage::helper("landingpage")->__("Name"),
						"name" => "name",
						));	

						$fieldset->addField("category", "text", array(
						"label" => Mage::helper("landingpage")->__("Category"),
						"name" => "category",
						));
					
						$fieldset->addField("url", "text", array(
						"label" => Mage::helper("landingpage")->__("URL"),
						"name" => "url",
						));
					
						$fieldset->addField("content", "textarea", array(
						"label" => Mage::helper("landingpage")->__("Content"),
						"name" => "content",
						));
									
						$fieldset->addField('image', 'image', array(
						'label' => Mage::helper('landingpage')->__('Image'),
						'name' => 'image',
						'note' => '(*.jpg, *.png, *.gif)',
						));

				if (Mage::getSingleton("adminhtml/session")->getManData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getManData());
					Mage::getSingleton("adminhtml/session")->setManData(null);
				} 
				elseif(Mage::registry("man_data")) {
				    $form->setValues(Mage::registry("man_data")->getData());
				}
				return parent::_prepareForm();
		}
}
