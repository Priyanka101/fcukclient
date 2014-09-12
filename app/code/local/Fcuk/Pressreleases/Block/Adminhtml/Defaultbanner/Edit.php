<?php
	
class Fcuk_Pressreleases_Block_Adminhtml_Defaultbanner_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "banner_id";
				$this->_blockGroup = "pressreleases";
				$this->_controller = "adminhtml_defaultbanner";
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
				if( Mage::registry("defaultbanner_data") && Mage::registry("defaultbanner_data")->getId() ){

				    return Mage::helper("pressreleases")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("defaultbanner_data")->getId()));

				} 
				else{

				     return Mage::helper("pressreleases")->__("Add Item");

				}
		}
}