<?php

class Addons_Storelocator_Block_Adminhtml_Storelocator_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	
		public function __construct()
		{
				
				parent::__construct();
				$this->setId("storelocatorGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("storelocator/storelocator")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				
				$this->addColumn("id", array(
				"header" => Mage::helper("storelocator")->__("ID"),
				"align" =>"right",
				"width" => "50px",
				"index" => "id",
				));
				
				$this->addColumn("name", array(
				"header" => Mage::helper("storelocator")->__("Name"),
				"align" =>"right",
				"width" => "200px",
				"index" => "name",
				));
				
				$this->addColumn("address", array(
				"header" => Mage::helper("storelocator")->__("Address"),
				"align" =>"right",
				"width" => "200px",
				"index" => "address",
				));
				
				$this->addColumn("area", array(
				"header" => Mage::helper("storelocator")->__("Area"),
				"align" =>"right",
				"width" => "200px",
				"index" => "area",
				));
				$this->addColumn("landmark", array(
				"header" => Mage::helper("storelocator")->__("Google Map Locator"),
				"align" =>"right",
				"width" => "200px",
				"index" => "landmark",
				));
				$this->addColumn("city", array(
				"header" => Mage::helper("storelocator")->__("City"),
				"align" =>"right",
				"width" => "200px",
				"index" => "city",
				));
				/*$this->addColumn("state", array(
				"header" => Mage::helper("storelocator")->__("State"),
				"align" =>"right",
				"width" => "200px",
				"index" => "state",
				));*/
				/*$this->addColumn("zip", array(
				"header" => Mage::helper("storelocator")->__("Zip"),
				"align" =>"right",
				"width" => "200px",
				"index" => "zip",
				));
				
				$this->addColumn("contact_person", array(
				"header" => Mage::helper("storelocator")->__("Contact Person"),
				"align" =>"right",
				"width" => "200px",
				"index" => "contact_person",
				));
				
				$this->addColumn("mobile", array(
				"header" => Mage::helper("storelocator")->__("Mobile"),
				"align" =>"right",
				"width" => "200px",
				"index" => "mobile",
				));*/
				
				$this->addColumn("phone", array(
				"header" => Mage::helper("storelocator")->__("Phone"),
				"align" =>"right",
				"width" => "200px",
				"index" => "phone",
				));
				
				$this->addColumn("email", array(
				"header" => Mage::helper("storelocator")->__("Email"),
				"align" =>"right",
				"width" => "200px",
				"index" => "email",
				));
				
				$this->addColumn("gender", array(
					"header" => Mage::helper("storelocator")->__("Gender"),
					"align" =>"right",
					"width" => "200px",
					"index" => "gender",
					"type" => "options" ,
					"options" =>array("1"=>"Women","0"=>"Men")
				
				));
				
            	
            	return parent::_prepareColumns();
		}
		/*protected function _getGender()
		{
			return 
		
		}*/
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('id');
			$this->getMassactionBlock()->setFormFieldName('id');
			 
			$this->getMassactionBlock()->addItem('delete', array(
			'label'=> Mage::helper('tax')->__('Delete'),
			'url'  => $this->getUrl('*/*/massDelete', array('' => '')),        // public function massDeleteAction() in Mage_Adminhtml_Tax_RateController
			'confirm' => Mage::helper('tax')->__('Are you sure?')
			));
			 
			return $this;
		}
		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}

}