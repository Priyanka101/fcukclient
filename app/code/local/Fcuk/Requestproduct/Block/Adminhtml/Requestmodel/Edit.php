<?php
	
class Fcuk_Requestproduct_Block_Adminhtml_Requestmodel_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "requestproduct_id";
				$this->_blockGroup = "requestproduct";
				$this->_controller = "adminhtml_requestmodel";
				$this->_updateButton("save", "label", Mage::helper("requestproduct")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("requestproduct")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("requestproduct")->__("Save And Continue Edit"),
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
				if( Mage::registry("requestmodel_data") && Mage::registry("requestmodel_data")->getId() ){

				    return Mage::helper("requestproduct")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("requestmodel_data")->getId()));

				} 
				else{

				     return Mage::helper("requestproduct")->__("Add Item");

				}
		}
}