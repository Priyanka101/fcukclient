<?php

class Mac_Whitelies_Block_Adminhtml_Whitelies_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("whiteliesGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("whitelies/whitelies")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("whitelies")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id",
				));
                
				$this->addColumn('categoryname', array(
				'header' => Mage::helper('whitelies')->__('category Name '),
				'index' => 'categoryname',
				'type' => 'options',
				'options'=>Mac_Whitelies_Block_Adminhtml_Whitelies_Grid::getOptionArray1(),				
				));

				$this->addColumn("smallimage", array(
				"header" => Mage::helper("whitelies")->__("Small Image"),
				"index" => "smallimage",
				"renderer" =>"Mac_Whitelies_Block_Adminhtml_Renderer_Image",
				));

				$this->addColumn("thumbnail", array(
				"header" => Mage::helper("whitelies")->__("Thumbnail Image"),
				"index" => "thumbnail",
				"renderer" =>"Mac_Whitelies_Block_Adminhtml_Renderer_Image",
				));

				$this->addColumn("bannername", array(
				"header" => Mage::helper("whitelies")->__("Banner Name "),
				"index" => "bannername",
				));
				$this->addColumn("bannertype", array(
				"header" => Mage::helper("whitelies")->__("Banner Type "),
				"index" => "bannertype",
				));
				
				$this->addColumn("bannerno", array(
				"header" => Mage::helper("whitelies")->__("Banner No"),
				"index" => "bannerno",
				));
				$this->addColumn("bannerposition", array(
				"header" => Mage::helper("whitelies")->__("Banner Position"),
				"index" => "bannerposition",
				));	
				$this->addColumn("position", array(
				"header" => Mage::helper("whitelies")->__("Product Name Position"),
				"index" => "position",
				));	
				$this->addColumn("videourl", array(
				"header" => Mage::helper("whitelies")->__("Video URL"),
				"index" => "videourl",
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
			$this->getMassactionBlock()->addItem('remove_whitelies', array(
					 'label'=> Mage::helper('whitelies')->__('Remove Whitelies'),
					 'url'  => $this->getUrl('*/adminhtml_whitelies/massRemove'),
					 'confirm' => Mage::helper('whitelies')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray1()
		{
            $data_array=array(); 
			$data_array[0]='woman';
			$data_array[1]='man';
            return($data_array);
		}
		static public function getValueArray1()
		{
            $data_array=array();
			foreach(Mac_Whitelies_Block_Adminhtml_Whitelies_Grid::getOptionArray1() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}