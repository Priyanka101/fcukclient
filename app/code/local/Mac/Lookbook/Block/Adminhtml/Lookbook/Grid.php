<?php

class Mac_Lookbook_Block_Adminhtml_Lookbook_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("lookbookGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("lookbook/lookbook")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("lookbook")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id",
				));
                
				$this->addColumn("name", array(
				"header" => Mage::helper("lookbook")->__("Name"),
				"index" => "name",
				));
				$this->addColumn('category', array(
				'header' => Mage::helper('lookbook')->__('Category'),
				'index' => 'category',
				'type' => 'options',
				'options'=>Mac_Lookbook_Block_Adminhtml_Lookbook_Grid::getOptionArray2(),				
				));
				$this->addColumn("productsku", array(
				"header" => Mage::helper("lookbook")->__("Product SKU"),
				"index" => "productsku",
				));
				
				$this->addColumn("smallimage", array(
				"header" => Mage::helper("lookbook")->__("Small Image"),
				"index" => "smallimage",
				"renderer" =>"Mac_Lookbook_Block_Adminhtml_Renderer_Image",
				));
				
				$this->addColumn("thumbnailimage", array(
				"header" => Mage::helper("lookbook")->__("Look Image"),
				"index" => "thumbnailimage",
				"renderer" =>"Mac_Lookbook_Block_Adminhtml_Renderer_Image",
				));
				$this->addColumn("shopbylooksku", array(
				"header" => Mage::helper("lookbook")->__("Shop By Look SKU"),
				"index" => "shopbylooksku",
				));
				
				$this->addColumn("shopbylookurl", array(
				"header" => Mage::helper("lookbook")->__("Shop By Look URL"),
				"index" => "shopbylookurl",
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
			$this->getMassactionBlock()->addItem('remove_lookbook', array(
					 'label'=> Mage::helper('lookbook')->__('Remove Lookbook'),
					 'url'  => $this->getUrl('*/adminhtml_lookbook/massRemove'),
					 'confirm' => Mage::helper('lookbook')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray2()
		{
            $data_array=array(); 
			$data_array[0]='Man';
			$data_array[1]='Woman';
			$data_array[2]='No Category';
			
            return($data_array);
		}
		static public function getValueArray2()
		{
            $data_array=array();
			foreach(Mac_Lookbook_Block_Adminhtml_Lookbook_Grid::getOptionArray2() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}