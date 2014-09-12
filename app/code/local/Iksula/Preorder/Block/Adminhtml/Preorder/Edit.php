<?php
	
class Iksula_Preorder_Block_Adminhtml_Preorder_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "preorder_id";
				$this->_blockGroup = "preorder";
				$this->_controller = "adminhtml_preorder";
				$this->_updateButton("save", "label", Mage::helper("preorder")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("preorder")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("preorder")->__("Save And Continue Edit"),
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
				if( Mage::registry("preorder_data") && Mage::registry("preorder_data")->getId() ){

				    return Mage::helper("preorder")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("preorder_data")->getId()));

				} 
				else{

				     return Mage::helper("preorder")->__("Add Item");

				}
		}
}