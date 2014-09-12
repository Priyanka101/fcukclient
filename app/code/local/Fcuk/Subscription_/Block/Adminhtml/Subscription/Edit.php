<?php
	
class Fcuk_Subscription_Block_Adminhtml_Subscription_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "s_id";
				$this->_blockGroup = "subscription";
				$this->_controller = "adminhtml_subscription";
				$this->_updateButton("save", "label", Mage::helper("subscription")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("subscription")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("subscription")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("subscription_data") && Mage::registry("subscription_data")->getId() ){

				    return Mage::helper("subscription")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("subscription_data")->getId()));

				} 
				else{

				     return Mage::helper("subscription")->__("Add Item");

				}
		}
}