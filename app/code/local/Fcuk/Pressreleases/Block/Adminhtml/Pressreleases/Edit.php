<?php
	
class Fcuk_Pressreleases_Block_Adminhtml_Pressreleases_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "release_id";
				$this->_blockGroup = "pressreleases";
				$this->_controller = "adminhtml_pressreleases";
				$this->_updateButton("save", "label", Mage::helper("pressreleases")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("pressreleases")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("pressreleases")->__("Save And Continue Edit"),
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
				if( Mage::registry("pressreleases_data") && Mage::registry("pressreleases_data")->getId() ){

				    return Mage::helper("pressreleases")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("pressreleases_data")->getId()));

				} 
				else{

				     return Mage::helper("pressreleases")->__("Add Item");

				}
		}
}