<?php

class Fcuk_Check_Block_Adminhtml_Noncod_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("noncodGrid");
				$this->setDefaultSort("ncod_id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("check/noncod")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("ncod_id", array(
				"header" => Mage::helper("check")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "ncod_id",
				));
                
				$this->addColumn("pincode", array(
				"header" => Mage::helper("check")->__("pincode"),
				"index" => "pincode",
				));
				$this->addColumn("city", array(
				"header" => Mage::helper("check")->__("city"),
				"index" => "city",
				));
				$this->addColumn("location", array(
				"header" => Mage::helper("check")->__("location"),
				"index" => "location",
				));
				$this->addColumn("state", array(
				"header" => Mage::helper("check")->__("state"),
				"index" => "state",
				));
				$this->addColumn("ncod", array(
				"header" => Mage::helper("check")->__("ncod"),
				"index" => "ncod",
				));
				$this->addColumn("zone", array(
				"header" => Mage::helper("check")->__("zone"),
				"index" => "zone",
				));
				
				$this->addColumn("eastzone", array(
				"header" => Mage::helper("check")->__("East Zone"),
				"index" => "eastzone",
				));
				
				$this->addColumn("carrier", array(
				"header" => Mage::helper("check")->__("Carrier"),
				"index" => "carrier",
				));
				
										
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('ncod_id');
			$this->getMassactionBlock()->setFormFieldName('ncod_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_noncod', array(
					 'label'=> Mage::helper('check')->__('Remove Noncod'),
					 'url'  => $this->getUrl('*/adminhtml_noncod/massRemove'),
					 'confirm' => Mage::helper('check')->__('Are you sure?')
				));
			return $this;
		}
			

}