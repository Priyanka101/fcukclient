<?php

class Mac_Landingpages_Block_Adminhtml_Landingpages_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("landingpagesGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("landingpages/landingpages")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("landingpages")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id",
				));
                
				$this->addColumn("catname", array(
				"header" => Mage::helper("landingpages")->__("Category Name"),
				"index" => "catname",
				));
				$this->addColumn("imageposition", array(
				"header" => Mage::helper("landingpages")->__("Image Position"),
				"index" => "imageposition",
				));
				$this->addColumn("url", array(
				"header" => Mage::helper("landingpages")->__("URL"),
				"index" => "url",
				));	
				$this->addColumn("bannerimage", array(
				"header" => Mage::helper("landingpages")->__("Image"),
				"index" => "bannerimage",
				"renderer" =>"Mac_Landingpages_Block_Adminhtml_Renderer_Image",
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
			$this->setMassactionIdField('id');
			$this->getMassactionBlock()->setFormFieldName('ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_landingpages', array(
					 'label'=> Mage::helper('landingpages')->__('Remove Landingpages'),
					 'url'  => $this->getUrl('*/adminhtml_landingpages/massRemove'),
					 'confirm' => Mage::helper('landingpages')->__('Are you sure?')
				));
			return $this;
		}
			

}