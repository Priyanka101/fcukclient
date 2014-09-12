<?php
	
class Fcuk_Check_Block_Adminhtml_Noncod_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "ncod_id";
				$this->_blockGroup = "check";
				$this->_controller = "adminhtml_noncod";
				$this->_updateButton("save", "label", Mage::helper("check")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("check")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("check")->__("Save And Continue Edit"),
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
				if( Mage::registry("noncod_data") && Mage::registry("noncod_data")->getId() ){

				    return Mage::helper("check")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("noncod_data")->getId()));

				} 
				else{

				     return Mage::helper("check")->__("Add Item");

				}
		}
}