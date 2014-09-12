<?php
class Mac_Lookbook_Block_Adminhtml_Lookbook_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("lookbook_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("lookbook")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("lookbook")->__("Item Information"),
				"title" => Mage::helper("lookbook")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("lookbook/adminhtml_lookbook_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
