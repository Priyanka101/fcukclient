<?php
class Mac_Lookbook_Block_Adminhtml_Lookbook_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("lookbook_form", array("legend"=>Mage::helper("lookbook")->__("Item information")));

				
						$fieldset->addField("name", "text", array(
						"label" => Mage::helper("lookbook")->__("Name"),
						"name" => "name",
						));
									
						 $fieldset->addField('category', 'select', array(
						'label'     => Mage::helper('lookbook')->__('Category'),
						'values'   => Mac_Lookbook_Block_Adminhtml_Lookbook_Grid::getValueArray2(),
						'name' => 'category',
						));				
						$fieldset->addField('smallimage', 'image', array(
						'label' => Mage::helper('lookbook')->__('Small Image'),
						'name' => 'smallimage',
						'note' => '(*.jpg, *.png, *.gif)',
						));				
						$fieldset->addField('thumbnailimage', 'image', array(
						'label' => Mage::helper('lookbook')->__('Look Image'),
						'name' => 'thumbnailimage',
						'note' => '(*.jpg, *.png, *.gif)',
						));
						$fieldset->addField("productsku", "textarea", array(
						"label" => Mage::helper("lookbook")->__("Product SKU"),
						"name" => "productsku",
						));
					
						$fieldset->addField("shopbylooksku", "textarea", array(
						"label" => Mage::helper("lookbook")->__("Shop By Look SKU"),
						"name" => "shopbylooksku",
						));
					
						$fieldset->addField("shopbylookurl", "text", array(
						"label" => Mage::helper("lookbook")->__("Shop By Look URL"),
						"name" => "shopbylookurl",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getLookbookData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getLookbookData());
					Mage::getSingleton("adminhtml/session")->setLookbookData(null);
				} 
				elseif(Mage::registry("lookbook_data")) {
				    $form->setValues(Mage::registry("lookbook_data")->getData());
				}
				return parent::_prepareForm();
		}
}
