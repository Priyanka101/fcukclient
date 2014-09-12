<?php

class Iksula_Paymentinfo_Block_Adminhtml_Paymentinfo_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("paymentinfoGrid");
				$this->setDefaultSort("payment_info_id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("paymentinfo/paymentinfo")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("payment_info_id", array(
				"header" => Mage::helper("paymentinfo")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "payment_info_id",
				));
                
				$this->addColumn("name", array(
				"header" => Mage::helper("paymentinfo")->__("Payment Name"),
				"index" => "name",
				));
				$this->addColumn("payment_type", array(
				"header" => Mage::helper("paymentinfo")->__("Payment Method Type"),
				"index" => "payment_type",
				));
				$this->addColumn("price", array(
				"header" => Mage::helper("paymentinfo")->__("Price"),
				"index" => "price",
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
			$this->setMassactionIdField('payment_info_id');
			$this->getMassactionBlock()->setFormFieldName('payment_info_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_paymentinfo', array(
					 'label'=> Mage::helper('paymentinfo')->__('Remove Paymentinfo'),
					 'url'  => $this->getUrl('*/adminhtml_paymentinfo/massRemove'),
					 'confirm' => Mage::helper('paymentinfo')->__('Are you sure?')
				));
			return $this;
		}
			

}