<?php
class Fcuk_Subscription_Block_Adminhtml_Subscription_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("subscription_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("subscription")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("subscription")->__("Item Information"),
				"title" => Mage::helper("subscription")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("subscription/adminhtml_subscription_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
