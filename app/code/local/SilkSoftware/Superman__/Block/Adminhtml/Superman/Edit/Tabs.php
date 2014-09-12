<?php
class SilkSoftware_Superman_Block_Adminhtml_Superman_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("superman_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("superman")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("superman")->__("Item Information"),
				"title" => Mage::helper("superman")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("superman/adminhtml_superman_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
