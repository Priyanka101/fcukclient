<?php
	
class Iksula_Paymentinfo_Block_Adminhtml_Paymentinfo_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "payment_info_id";
				$this->_blockGroup = "paymentinfo";
				$this->_controller = "adminhtml_paymentinfo";
				$this->_updateButton("save", "label", Mage::helper("paymentinfo")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("paymentinfo")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("paymentinfo")->__("Save And Continue Edit"),
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
				if( Mage::registry("paymentinfo_data") && Mage::registry("paymentinfo_data")->getId() ){

				    return Mage::helper("paymentinfo")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("paymentinfo_data")->getId()));

				} 
				else{

				     return Mage::helper("paymentinfo")->__("Add Item");

				}
		}
}