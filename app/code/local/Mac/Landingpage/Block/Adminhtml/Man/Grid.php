<?php

class Mac_Landingpage_Block_Adminhtml_Man_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("manGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("landingpage/man")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("landingpage")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id",
				));
                
				$this->addColumn("name", array(
				"header" => Mage::helper("landingpage")->__("Name"),
				"index" => "name",
				));

				$this->addColumn("category", array(
				"header" => Mage::helper("landingpage")->__("Category"),
				"index" => "category",
				));
				$this->addColumn("url", array(
				"header" => Mage::helper("landingpage")->__("URL"),
				"index" => "url",
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
			$this->getMassactionBlock()->addItem('remove_man', array(
					 'label'=> Mage::helper('landingpage')->__('Remove Man'),
					 'url'  => $this->getUrl('*/adminhtml_man/massRemove'),
					 'confirm' => Mage::helper('landingpage')->__('Are you sure?')
				));
			return $this;
		}
			

}