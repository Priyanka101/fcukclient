<?php

class Mac_Requestcatalog_Block_Adminhtml_Requestcatalog_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("requestcatalogGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("requestcatalog/requestcatalog")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("requestcatalog")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id",
				));
                
						$this->addColumn('title', array(
						'header' => Mage::helper('requestcatalog')->__('Title'),
						'index' => 'title',
						'type' => 'options',
						'options'=>Mac_Requestcatalog_Block_Adminhtml_Requestcatalog_Grid::getOptionArray1(),				
						));
						
				$this->addColumn("firstname", array(
				"header" => Mage::helper("requestcatalog")->__("First Name"),
				"index" => "firstname",
				));
				$this->addColumn("lastname", array(
				"header" => Mage::helper("requestcatalog")->__("Last Name"),
				"index" => "lastname",
				));
				$this->addColumn("email", array(
				"header" => Mage::helper("requestcatalog")->__("Email"),
				"index" => "email",
				));
				$this->addColumn("city", array(
				"header" => Mage::helper("requestcatalog")->__("City"),
				"index" => "city",
				));
				$this->addColumn("postcode", array(
				"header" => Mage::helper("requestcatalog")->__("Postcode"),
				"index" => "postcode",
				));
				$this->addColumn("state", array(
				"header" => Mage::helper("requestcatalog")->__("State"),
				"index" => "state",
				));
				$this->addColumn("country", array(
				"header" => Mage::helper("requestcatalog")->__("Country"),
				"index" => "country",
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
			$this->getMassactionBlock()->addItem('remove_requestcatalog', array(
					 'label'=> Mage::helper('requestcatalog')->__('Remove Requestcatalog'),
					 'url'  => $this->getUrl('*/adminhtml_requestcatalog/massRemove'),
					 'confirm' => Mage::helper('requestcatalog')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray1()
		{
            $data_array=array(); 
			$data_array[0]='Mr';
			$data_array[1]='Mrs';
			$data_array[2]='Miss';
			$data_array[3]='Ms';
			$data_array[4]='Dr';
            return($data_array);
		}
		static public function getValueArray1()
		{
            $data_array=array();
			foreach(Mac_Requestcatalog_Block_Adminhtml_Requestcatalog_Grid::getOptionArray1() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}