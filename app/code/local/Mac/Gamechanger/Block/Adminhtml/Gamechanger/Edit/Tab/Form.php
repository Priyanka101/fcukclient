<?php
class Mac_Gamechanger_Block_Adminhtml_Gamechanger_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);

				$fieldset = $form->addFieldset("gamechanger_form", array("legend"=>Mage::helper("gamechanger")->__("Item information")));

				
						$fieldset->addField("categoryname", "text", array(
						"label" => Mage::helper("gamechanger")->__("Category Name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "categoryname",
						));
						$url=$this->getSkinUrl('images/gamechanger.png');
									echo "<img src=$url />";
						 $fieldset->addField('bannertype', 'select', array(
						'label'     => Mage::helper('gamechanger')->__('Banner Type'),
						'values'   => Mac_Gamechanger_Block_Adminhtml_Gamechanger_Grid::getValueArray2(),
						'name' => 'bannertype',					
						"class" => "required-entry",
						"required" => true,
						));
						$fieldset->addField("bannerno", "text", array(
						"label" => Mage::helper("gamechanger")->__("Banner No"),
						"name" => "bannerno",
						));
					
						$fieldset->addField("bannerposition", "text", array(
						"label" => Mage::helper("gamechanger")->__("Banner Position"),
						"name" => "bannerposition",

						'note' => '(use above figure -1 for the banner position depending on image size)',
						));
					
						$fieldset->addField("content", "text", array(
						"label" => Mage::helper("gamechanger")->__("Content"),
						"name" => "content",
						));
					
						$fieldset->addField("url", "text", array(
						"label" => Mage::helper("gamechanger")->__("URL"),
						"name" => "url",
						));
									
						$fieldset->addField('image', 'image', array(
						'label' => Mage::helper('gamechanger')->__('Image'),
						'name' => 'image',
						'note' => '(*.jpg, *.png, *.gif)',
						));

				if (Mage::getSingleton("adminhtml/session")->getGamechangerData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getGamechangerData());
					Mage::getSingleton("adminhtml/session")->setGamechangerData(null);
				} 
				elseif(Mage::registry("gamechanger_data")) {
				    $form->setValues(Mage::registry("gamechanger_data")->getData());
				}
				return parent::_prepareForm();
		}
}
