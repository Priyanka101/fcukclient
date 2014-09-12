<?php
class Mac_Gamechanger_Block_Adminhtml_Gamechanger_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("gamechanger_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("gamechanger")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("gamechanger")->__("Item Information"),
				"title" => Mage::helper("gamechanger")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("gamechanger/adminhtml_gamechanger_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
