<?php
class Mac_Whitelies_Block_Adminhtml_Whitelies_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("whitelies_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("whitelies")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("whitelies")->__("Item Information"),
				"title" => Mage::helper("whitelies")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("whitelies/adminhtml_whitelies_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
