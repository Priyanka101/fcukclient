<?php
class Fcuk_Shiptrack_Block_Adminhtml_Shipment_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("shipment_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("shiptrack")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("shiptrack")->__("Item Information"),
				"title" => Mage::helper("shiptrack")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("shiptrack/adminhtml_shipment_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
