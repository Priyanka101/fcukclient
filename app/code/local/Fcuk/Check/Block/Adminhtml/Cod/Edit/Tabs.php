<?php
class Fcuk_Check_Block_Adminhtml_Cod_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("cod_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("check")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("check")->__("Item Information"),
				"title" => Mage::helper("check")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("check/adminhtml_cod_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
