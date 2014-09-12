<?php
	
class SilkSoftware_Superman_Block_Adminhtml_Superman_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "customer_id";
				$this->_blockGroup = "superman";
				$this->_controller = "adminhtml_superman";
				$this->_updateButton("save", "label", Mage::helper("superman")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("superman")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("superman")->__("Save And Continue Edit"),
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
				if( Mage::registry("superman_data") && Mage::registry("superman_data")->getId() ){

				    return Mage::helper("superman")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("superman_data")->getId()));

				} 
				else{

				     return Mage::helper("superman")->__("Add Item");

				}
		}
}