<?php

class SilkSoftware_Storelocator_Block_Adminhtml_Storelocator_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("storelocatorGrid");
				$this->setDefaultSort("store_id");
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
				$this->addColumn("store_id", array(
				"header" => Mage::helper("storelocator")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "store_id",
				));
                
				$this->addColumn("store", array(
				"header" => Mage::helper("storelocator")->__("Store"),
				"index" => "store",
				));
				$this->addColumn("city", array(
				"header" => Mage::helper("storelocator")->__("City"),
				"index" => "city",
				));
				$this->addColumn("pincode", array(
				"header" => Mage::helper("storelocator")->__("pin code"),
				"index" => "pincode",
				));
				$this->addColumn("tel_number", array(
				"header" => Mage::helper("storelocator")->__("telephone number"),
				"index" => "tel_number",
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
			$this->setMassactionIdField('store_id');
			$this->getMassactionBlock()->setFormFieldName('store_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_storelocator', array(
					 'label'=> Mage::helper('storelocator')->__('Remove Storelocator'),
					 'url'  => $this->getUrl('*/adminhtml_storelocator/massRemove'),
					 'confirm' => Mage::helper('storelocator')->__('Are you sure?')
				));
			return $this;
		}
			

}