<?php
class Mac_Requestcatalog_Block_Adminhtml_Requestcatalog_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("requestcatalog_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("requestcatalog")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("requestcatalog")->__("Item Information"),
				"title" => Mage::helper("requestcatalog")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("requestcatalog/adminhtml_requestcatalog_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
