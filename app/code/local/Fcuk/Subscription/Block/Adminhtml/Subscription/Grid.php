<?php

class Fcuk_Subscription_Block_Adminhtml_Subscription_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("subscriptionGrid");
				$this->setDefaultSort("s_id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("subscription/subscription")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("s_id", array(
				"header" => Mage::helper("subscription")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "s_id",
				));
                
				$this->addColumn("email", array(
				"header" => Mage::helper("subscription")->__("Suggestions"),
				"index" => "email",
				));
				/* $this->addColumn("mobileno", array(
				"header" => Mage::helper("subscription")->__("mobileno"),
				"index" => "mobileno",
				)); */
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
			$this->getMassactionBlock()->addItem('remove_subscription', array(
					 'label'=> Mage::helper('subscription')->__('Remove Help Us'),
					 'url'  => $this->getUrl('*/adminhtml_subscription/massRemove'),
					 'confirm' => Mage::helper('subscription')->__('Are you sure?')
				));
			return $this;
		}
			

}