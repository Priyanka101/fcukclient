<?php

class Fcuk_Pressreleases_Block_Adminhtml_Defaultbanner_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("defaultbannerGrid");
				$this->setDefaultSort("banner_id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("pressreleases/defaultbanner")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("banner_id", array(
				"header" => Mage::helper("pressreleases")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "banner_id",
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
			$this->setMassactionIdField('banner_id');
			$this->getMassactionBlock()->setFormFieldName('banner_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_defaultbanner', array(
					 'label'=> Mage::helper('pressreleases')->__('Remove Defaultbanner'),
					 'url'  => $this->getUrl('*/adminhtml_defaultbanner/massRemove'),
					 'confirm' => Mage::helper('pressreleases')->__('Are you sure?')
				));
			return $this;
		}
			

}