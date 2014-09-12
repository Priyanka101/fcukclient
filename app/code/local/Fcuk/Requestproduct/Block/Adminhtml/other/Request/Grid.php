<?php

class Fcuk_Requestproduct_Block_Adminhtml_Request_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("requestGrid");
				$this->setDefaultSort("requestproduct_id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("requestproduct/request")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("requestproduct_id", array(
				"header" => Mage::helper("requestproduct")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "requestproduct_id",
				));
                
				$this->addColumn("name", array(
				"header" => Mage::helper("requestproduct")->__("name"),
				"index" => "name",
				));
				$this->addColumn("email", array(
				"header" => Mage::helper("requestproduct")->__("email"),
				"index" => "email",
				));
				$this->addColumn("phoneno", array(
				"header" => Mage::helper("requestproduct")->__("phoneno"),
				"index" => "phoneno",
				));
				$this->addColumn("productid", array(
				"header" => Mage::helper("requestproduct")->__("productid"),
				"index" => "productid",
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
			$this->setMassactionIdField('requestproduct_id');
			$this->getMassactionBlock()->setFormFieldName('requestproduct_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_request', array(
					 'label'=> Mage::helper('requestproduct')->__('Remove Request'),
					 'url'  => $this->getUrl('*/adminhtml_request/massRemove'),
					 'confirm' => Mage::helper('requestproduct')->__('Are you sure?')
				));
			return $this;
		}
			

}