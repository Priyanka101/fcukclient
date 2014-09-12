<?php
class Mac_Whitelies_Block_Adminhtml_Whitelies_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("whitelies_form", array("legend"=>Mage::helper("whitelies")->__("Item information")));

								
						 $fieldset->addField('categoryname', 'select', array(
						'label'     => Mage::helper('whitelies')->__('category Name '),
						'values'   => Mac_Whitelies_Block_Adminhtml_Whitelies_Grid::getValueArray1(),
						'name' => 'categoryname',
						));
						$fieldset->addField("bannername", "text", array(
						"label" => Mage::helper("whitelies")->__("Banner Name "),
						"name" => "bannername",
						));
					
						$fieldset->addField("bannertype", "text", array(
						"label" => Mage::helper("whitelies")->__("Banner Type "),
						"name" => "bannertype",
						));
						
						$fieldset->addField("bannerno", "text", array(
						"label" => Mage::helper("whitelies")->__("Banner No"),
						"name" => "bannerno",
						));
						
						$fieldset->addField("bannerposition", "text", array(
						"label" => Mage::helper("whitelies")->__("Banner Position"),
						"name" => "bannerposition",
						));
						
						$fieldset->addField("position", "text", array(
						"label" => Mage::helper("whitelies")->__("Product Name Position"),
						"name" => "position",
						'note' => '(1-for top left,2-for top right 3-for bottom left,4-for bottom right)',
						));
											
						$fieldset->addField("videourl", "textarea", array(
						"label" => Mage::helper("whitelies")->__("Video URL"),
						"name" => "videourl",
						));
					
						$fieldset->addField("content", "textarea", array(
						"label" => Mage::helper("whitelies")->__("Content"),
						"name" => "content",
						));
					
						$fieldset->addField("productid", "textarea", array(
						"label" => Mage::helper("whitelies")->__("Product ID"),
						"name" => "productid",
						));
					
						$fieldset->addField("url", "textarea", array(
						"label" => Mage::helper("whitelies")->__("URL"),
						"name" => "url",
						));
									
						$fieldset->addField('smallimage', 'image', array(
						'label' => Mage::helper('whitelies')->__('Small Image'),
						'name' => 'smallimage',
						'note' => '(*.jpg, *.png, *.gif)',
						));				
						$fieldset->addField('thumbnail', 'image', array(
						'label' => Mage::helper('whitelies')->__('Thumbnail Image'),
						'name' => 'thumbnail',
						'note' => '(*.jpg, *.png, *.gif)',
						));
						
						$fieldset->addField('video', 'image', array(
						'label' => Mage::helper('whitelies')->__('Video'),
						'name' => 'video',
						));

				if (Mage::getSingleton("adminhtml/session")->getWhiteliesData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getWhiteliesData());
					Mage::getSingleton("adminhtml/session")->setWhiteliesData(null);
				} 
				elseif(Mage::registry("whitelies_data")) {
				    $form->setValues(Mage::registry("whitelies_data")->getData());
				}
				return parent::_prepareForm();
		}
}
