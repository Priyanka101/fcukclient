<?php
class Mac_Custom_Block_Adminhtml_Kittedout_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("custom_form", array("legend"=>Mage::helper("custom")->__("Item information")));

								
						 $fieldset->addField('categoryname', 'select', array(
						'label'     => Mage::helper('custom')->__('Category Name'),
						'values'   => Mac_Custom_Block_Adminhtml_Kittedout_Grid::getValueArray1(),
						'name' => 'categoryname',
						));
						$fieldset->addField("bannername", "text", array(
						"label" => Mage::helper("custom")->__("Banner Name"),
						"name" => "bannername",
						));
					
						$fieldset->addField("bannertype", "text", array(
						"label" => Mage::helper("custom")->__("Banner type"),
						"name" => "bannertype",
						));
					
						$fieldset->addField("bannerno", "text", array(
						"label" => Mage::helper("custom")->__("Banner No"),
						"name" => "bannerno",
						));
					
						$fieldset->addField("bannerposition", "text", array(
						"label" => Mage::helper("custom")->__("Banner Position"),
						"name" => "bannerposition",
						));
					
						$fieldset->addField("degreeofrotation", "text", array(
						"label" => Mage::helper("custom")->__("Degree of Rotation "),
						"name" => "degreeofrotation",
						));
					
						$fieldset->addField("content", "textarea", array(
						"label" => Mage::helper("custom")->__("Content"),
						"name" => "content",
						));
					
						$fieldset->addField("url", "textarea", array(
						"label" => Mage::helper("custom")->__("Url"),
						"name" => "url",
						));
									
						$fieldset->addField('smallimage', 'image', array(
						'label' => Mage::helper('custom')->__('Small Image'),
						'name' => 'smallimage',
						'note' => '(*.jpg, *.png, *.gif)',
						));				
						$fieldset->addField('thumbnail', 'image', array(
						'label' => Mage::helper('custom')->__('Thumbnail Image'),
						'name' => 'thumbnail',
						'note' => '(*.jpg, *.png, *.gif)',
						));

				if (Mage::getSingleton("adminhtml/session")->getKittedoutData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getKittedoutData());
					Mage::getSingleton("adminhtml/session")->setKittedoutData(null);
				} 
				elseif(Mage::registry("kittedout_data")) {
				    $form->setValues(Mage::registry("kittedout_data")->getData());
				}
				return parent::_prepareForm();
		}
}
