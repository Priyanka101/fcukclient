<?php

class Iksula_Preorder_Block_Adminhtml_Preorder_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("preorderGrid");
				$this->setDefaultSort("preorder_id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("preorder/preorder")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("preorder_id", array(
				"header" => Mage::helper("preorder")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "preorder_id",
				));
                
				$this->addColumn("customer_firstname", array(
				"header" => Mage::helper("preorder")->__("First Name"),
				"index" => "customer_firstname",
				));
				$this->addColumn("customer_lastname", array(
				"header" => Mage::helper("preorder")->__("Last Name"),
				"index" => "customer_lastname",
				));
				$this->addColumn("customer_address", array(
				"header" => Mage::helper("preorder")->__("Address"),
				"index" => "customer_address",
				));
				$this->addColumn("customer_email", array(
				"header" => Mage::helper("preorder")->__("Email"),
				"index" => "customer_email",
				));
				$this->addColumn("product_name", array(
				"header" => Mage::helper("preorder")->__("Product Name"),
				"index" => "product_name",
				));
				$this->addColumn("product_sku", array(
				"header" => Mage::helper("preorder")->__("Product Sku"),
				"index" => "product_sku",
				));
				$this->addColumn("selected_size", array(
				"header" => Mage::helper("preorder")->__("Selected Size"),
				"index" => "selected_size",
				));
				$this->addColumn("selected_color", array(
				"header" => Mage::helper("preorder")->__("Selected Color"),
				"index" => "selected_color",
				));
				$this->addColumn("customer_city", array(
				"header" => Mage::helper("preorder")->__("City"),
				"index" => "customer_city",
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
			$this->setMassactionIdField('preorder_id');
			$this->getMassactionBlock()->setFormFieldName('preorder_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_preorder', array(
					 'label'=> Mage::helper('preorder')->__('Remove Preorder'),
					 'url'  => $this->getUrl('*/adminhtml_preorder/massRemove'),
					 'confirm' => Mage::helper('preorder')->__('Are you sure?')
				));
			return $this;
		}
			

}