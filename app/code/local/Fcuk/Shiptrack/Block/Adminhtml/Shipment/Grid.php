<?php

class Fcuk_Shiptrack_Block_Adminhtml_Shipment_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("shipmentGrid");
				$this->setDefaultSort("s_id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("shiptrack/shipment")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("s_id", array(
				"header" => Mage::helper("shiptrack")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "s_id",
				));
                
				$this->addColumn("awbnumber", array(
				"header" => Mage::helper("shiptrack")->__("awbnumber"),
				"index" => "awbnumber",
				));
				$this->addColumn("carrier", array(
				"header" => Mage::helper("shiptrack")->__("carrier"),
				"index" => "carrier",
				));
				$this->addColumn("status", array(
				"header" => Mage::helper("shiptrack")->__("status"),
				"index" => "status",
				));
				
				$this->addColumn("cod", array(
				"header" => Mage::helper("shiptrack")->__("cod"),
				"index" => "cod",
				));
										
				$this->addColumn("ncod", array(
				"header" => Mage::helper("shiptrack")->__("ncod"),
				"index" => "ncod",
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
			$this->setMassactionIdField('s_id');
			$this->getMassactionBlock()->setFormFieldName('s_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_shipment', array(
					 'label'=> Mage::helper('shiptrack')->__('Remove Shipment'),
					 'url'  => $this->getUrl('*/adminhtml_shipment/massRemove'),
					 'confirm' => Mage::helper('shiptrack')->__('Are you sure?')
				));
			return $this;
		}
			

}