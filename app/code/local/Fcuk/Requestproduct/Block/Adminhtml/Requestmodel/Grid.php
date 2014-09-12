<?php

class Fcuk_Requestproduct_Block_Adminhtml_Requestmodel_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("requestmodelGrid");
				$this->setDefaultSort("requestproduct_id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("requestproduct/requestmodel")->getCollection();
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
                
				$this->addColumn("firstname", array(
				"header" => Mage::helper("requestproduct")->__("First Name"),
				"index" => "firstname",
				));
				$this->addColumn("lastname", array(
				"header" => Mage::helper("requestproduct")->__("Last Name"),
				"index" => "lastname",
				));
					$this->addColumn("address", array(
				"header" => Mage::helper("requestproduct")->__("Address"),
				"index" => "address",
				));
					$this->addColumn("city", array(
				"header" => Mage::helper("requestproduct")->__("City"),
				"index" => "city",
				));
				
				$this->addColumn("email", array(
				"header" => Mage::helper("requestproduct")->__("Email"),
				"index" => "email",
				));
				$this->addColumn("phoneno", array(
				"header" => Mage::helper("requestproduct")->__("Phoneno"),
				"index" => "phoneno",
				));
					$this->addColumn("productname", array(
				"header" => Mage::helper("requestproduct")->__("Product Name"),
				"index" => "productname",
				));
				$this->addColumn("stylecode", array(
				"header" => Mage::helper("requestproduct")->__("Style Code"),
				"index" => "stylecode",
				));
					$this->addColumn("size", array(
				"header" => Mage::helper("requestproduct")->__("Size"),
				"index" => "size",
				));
					$this->addColumn("color", array(
				"header" => Mage::helper("requestproduct")->__("Color"),
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
			$this->setMassactionIdField('requestproduct_id');
			$this->getMassactionBlock()->setFormFieldName('requestproduct_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_requestmodel', array(
					 'label'=> Mage::helper('requestproduct')->__('Remove Requestmodel'),
					 'url'  => $this->getUrl('*/adminhtml_requestmodel/massRemove'),
					 'confirm' => Mage::helper('requestproduct')->__('Are you sure?')
				));
			return $this;
		}
			

}