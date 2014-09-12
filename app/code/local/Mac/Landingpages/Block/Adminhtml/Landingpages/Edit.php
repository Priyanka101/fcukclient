<?php
	
class Mac_Landingpages_Block_Adminhtml_Landingpages_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "id";
				$this->_blockGroup = "landingpages";
				$this->_controller = "adminhtml_landingpages";
				$this->_updateButton("save", "label", Mage::helper("landingpages")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("landingpages")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("landingpages")->__("Save And Continue Edit"),
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
				if( Mage::registry("landingpages_data") && Mage::registry("landingpages_data")->getId() ){

				    return Mage::helper("landingpages")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("landingpages_data")->getId()));

				} 
				else{

				     return Mage::helper("landingpages")->__("Add Item");

				}
		}
}