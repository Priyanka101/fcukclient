<?php
class Iksula_Paymentinfo_Block_Adminhtml_Paymentinfo_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("paymentinfo_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("paymentinfo")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("paymentinfo")->__("Item Information"),
				"title" => Mage::helper("paymentinfo")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("paymentinfo/adminhtml_paymentinfo_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
