<?php
	
class Mac_Requestcatalog_Block_Adminhtml_Requestcatalog_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "id";
				$this->_blockGroup = "requestcatalog";
				$this->_controller = "adminhtml_requestcatalog";
				$this->_updateButton("save", "label", Mage::helper("requestcatalog")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("requestcatalog")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("requestcatalog")->__("Save And Continue Edit"),
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
				if( Mage::registry("requestcatalog_data") && Mage::registry("requestcatalog_data")->getId() ){

				    return Mage::helper("requestcatalog")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("requestcatalog_data")->getId()));

				} 
				else{

				     return Mage::helper("requestcatalog")->__("Add Item");

				}
		}
}