<?php

class Mac_Gamechanger_Block_Adminhtml_Gamechanger_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("gamechangerGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("gamechanger/gamechanger")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("gamechanger")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id",
				));
                
				$this->addColumn("categoryname", array(
				"header" => Mage::helper("gamechanger")->__("Category Name"),
				"index" => "categoryname",
				));
						$this->addColumn('bannertype', array(
						'header' => Mage::helper('gamechanger')->__('Banner Type'),
						'index' => 'bannertype',
						'type' => 'options',
						'options'=>Mac_Gamechanger_Block_Adminhtml_Gamechanger_Grid::getOptionArray2(),				
						));
						
				$this->addColumn("bannerno", array(
				"header" => Mage::helper("gamechanger")->__("Banner No"),
				"index" => "bannerno",
				));
				$this->addColumn("bannerposition", array(
				"header" => Mage::helper("gamechanger")->__("Banner Position"),
				"index" => "bannerposition",
				));
				$this->addColumn("content", array(
				"header" => Mage::helper("gamechanger")->__("Content"),
				"index" => "content",
				));
				$this->addColumn("url", array(
				"header" => Mage::helper("gamechanger")->__("URL"),
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
			$this->getMassactionBlock()->addItem('remove_gamechanger', array(
					 'label'=> Mage::helper('gamechanger')->__('Remove Gamechanger'),
					 'url'  => $this->getUrl('*/adminhtml_gamechanger/massRemove'),
					 'confirm' => Mage::helper('gamechanger')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray2()
		{
            $data_array=array(); 
			$data_array[0]='Single Banner';
			$data_array[1]='3 Column(1/3/2)';
			$data_array[2]='3 Column(2/1/3)';
			$data_array[3]='3 Column(3/1/2)';
	/*		$data_array[4]='2 Column(1/1)';
			$data_array[5]='2 Column(2/2)';
			$data_array[6]='2 Column(2/1)';
			$data_array[7]='2 Column(1/2)';*/
			
            return($data_array);
		}
		static public function getValueArray2()
		{
            $data_array=array();
			foreach(Mac_Gamechanger_Block_Adminhtml_Gamechanger_Grid::getOptionArray2() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}