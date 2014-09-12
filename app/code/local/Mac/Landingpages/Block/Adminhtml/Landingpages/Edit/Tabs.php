<?php
class Mac_Landingpages_Block_Adminhtml_Landingpages_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("landingpages_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("landingpages")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("landingpages")->__("Item Information"),
				"title" => Mage::helper("landingpages")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("landingpages/adminhtml_landingpages_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
