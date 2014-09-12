<?php
	
class Fcuk_Shiptrack_Block_Adminhtml_Shipment_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "s_id";
				$this->_blockGroup = "shiptrack";
				$this->_controller = "adminhtml_shipment";
				$this->_updateButton("save", "label", Mage::helper("shiptrack")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("shiptrack")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("shiptrack")->__("Save And Continue Edit"),
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
				if( Mage::registry("shipment_data") && Mage::registry("shipment_data")->getId() ){

				    return Mage::helper("shiptrack")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("shipment_data")->getId()));

				} 
				else{

				     return Mage::helper("shiptrack")->__("Add Item");

				}
		}
}