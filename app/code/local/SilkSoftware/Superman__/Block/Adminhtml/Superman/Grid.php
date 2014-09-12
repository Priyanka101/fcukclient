<?php

class SilkSoftware_Superman_Block_Adminhtml_Superman_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("supermanGrid");
				$this->setDefaultSort("customer_id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("superman/superman")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("customer_id", array(
				"header" => Mage::helper("superman")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "customer_id",
				));
                
				$this->addColumn("name", array(
				"header" => Mage::helper("superman")->__("customer name"),
				"index" => "name",
				));
				$this->addColumn("lastname", array(
				"header" => Mage::helper("superman")->__("last name "),
				"index" => "lastname",
				));
				$this->addColumn("city", array(
				"header" => Mage::helper("superman")->__("city "),
				"index" => "city",
				));
				$this->addColumn("zip", array(
				"header" => Mage::helper("superman")->__("zip "),
				"index" => "zip",
				));
				$this->addColumn("email", array(
				"header" => Mage::helper("superman")->__("email "),
				"index" => "email",
				));
				$this->addColumn("mobile", array(
				"header" => Mage::helper("superman")->__("mobile "),
				"index" => "mobile",
				));
				$this->addColumn("product_name", array(
				"header" => Mage::helper("superman")->__("product name "),
				"index" => "product_name",
				));
				$this->addColumn("sku", array(
				"header" => Mage::helper("superman")->__("sku "),
				"index" => "sku",
				));
				$this->addColumn("size", array(
				"header" => Mage::helper("superman")->__("size "),
				"index" => "size",
				));
				$this->addColumn("color", array(
				"header" => Mage::helper("superman")->__("color "),
				"index" => "color",
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
			$this->setMassactionIdField('customer_id');
			$this->getMassactionBlock()->setFormFieldName('customer_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_superman', array(
					 'label'=> Mage::helper('superman')->__('Remove Superman'),
					 'url'  => $this->getUrl('*/adminhtml_superman/massRemove'),
					 'confirm' => Mage::helper('superman')->__('Are you sure?')
				));
			return $this;
		}
			

}