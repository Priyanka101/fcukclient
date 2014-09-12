<?php

class Fcuk_Pressreleases_Block_Adminhtml_Presscoverage_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("presscoverageGrid");
				$this->setDefaultSort("coverage_id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("pressreleases/presscoverage")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("coverage_id", array(
				"header" => Mage::helper("pressreleases")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "coverage_id",
				));
                
				$this->addColumn("title", array(
				"header" => Mage::helper("pressreleases")->__("Title"),
				"index" => "title",
				));
					$this->addColumn('new_date', array(
						'header'    => Mage::helper('pressreleases')->__('Coverage Date'),
						'index'     => 'new_date',
						'type'      => 'datetime',
					));
				$this->addColumn("imagetitle", array(
				"header" => Mage::helper("pressreleases")->__("Image title"),
				"index" => "imagetitle",
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
			$this->setMassactionIdField('coverage_id');
			$this->getMassactionBlock()->setFormFieldName('coverage_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_presscoverage', array(
					 'label'=> Mage::helper('pressreleases')->__('Remove Presscoverage'),
					 'url'  => $this->getUrl('*/adminhtml_presscoverage/massRemove'),
					 'confirm' => Mage::helper('pressreleases')->__('Are you sure?')
				));
			return $this;
		}
			

}