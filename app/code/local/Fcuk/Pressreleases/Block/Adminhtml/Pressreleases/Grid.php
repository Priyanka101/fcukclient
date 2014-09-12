<?php

class Fcuk_Pressreleases_Block_Adminhtml_Pressreleases_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("pressreleasesGrid");
				$this->setDefaultSort("release_id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("pressreleases/pressreleases")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("release_id", array(
				"header" => Mage::helper("pressreleases")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "release_id",
				));
                
				$this->addColumn("release_name", array(
				"header" => Mage::helper("pressreleases")->__("Release name"),
				"index" => "release_name",
				));
					$this->addColumn('new_date', array(
						'header'    => Mage::helper('pressreleases')->__('Release Date'),
						'index'     => 'new_date',
						'type'      => 'datetime',
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
			$this->setMassactionIdField('release_id');
			$this->getMassactionBlock()->setFormFieldName('release_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_pressreleases', array(
					 'label'=> Mage::helper('pressreleases')->__('Remove Pressreleases'),
					 'url'  => $this->getUrl('*/adminhtml_pressreleases/massRemove'),
					 'confirm' => Mage::helper('pressreleases')->__('Are you sure?')
				));
			return $this;
		}
			

}