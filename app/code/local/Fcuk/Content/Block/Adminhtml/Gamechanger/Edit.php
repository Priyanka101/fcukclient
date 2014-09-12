<?php
	
class Fcuk_Content_Block_Adminhtml_Gamechanger_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "gamechangerid";
				$this->_blockGroup = "content";
				$this->_controller = "adminhtml_gamechanger";
				$this->_updateButton("save", "label", Mage::helper("content")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("content")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("content")->__("Save And Continue Edit"),
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
				if( Mage::registry("gamechanger_data") && Mage::registry("gamechanger_data")->getId() ){

				    return Mage::helper("content")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("gamechanger_data")->getId()));

				} 
				else{

				     return Mage::helper("content")->__("Add Item");

				}
		}
}