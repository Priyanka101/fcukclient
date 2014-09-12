<?php

class Mac_Custom_Block_Adminhtml_Kittedout_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("kittedoutGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("custom/kittedout")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("custom")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id",
				));
                
				$this->addColumn('categoryname', array(
				'header' => Mage::helper('custom')->__('Category Name'),
				'index' => 'categoryname',
				'type' => 'options',
				'options'=>Mac_Custom_Block_Adminhtml_Kittedout_Grid::getOptionArray1(),				
				));
						
				$this->addColumn("bannername", array(
				"header" => Mage::helper("custom")->__("Banner Name"),
				"index" => "bannername",
				));

				$this->addColumn("smallimage", array(
				"header" => Mage::helper('custom')->__('Image'),
				"index" => "smallimage",
				"renderer" =>"Mac_Custom_Block_Adminhtml_Renderer_Image",
				));	

				$this->addColumn("thumbnail", array(
				"header" => Mage::helper('custom')->__('Pop Up Image'),
				"index" => "thumbnail",
				"renderer" =>"Mac_Custom_Block_Adminhtml_Renderer_Image",
				));
					
			/*	$this->addColumn("bannertype", array(
				"header" => Mage::helper("custom")->__("Banner type"),
				"index" => "bannertype",
				));
				$this->addColumn("bannerno", array(
				"header" => Mage::helper("custom")->__("Banner No"),
				"index" => "bannerno",
				));
				$this->addColumn("bannerposition", array(
				"header" => Mage::helper("custom")->__("Banner Position"),
				"index" => "bannerposition",
				));*/

				$this->addColumn("degreeofrotation", array(
				"header" => Mage::helper("custom")->__("Degree of Rotation "),
				"index" => "degreeofrotation",
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
			$this->getMassactionBlock()->addItem('remove_kittedout', array(
					 'label'=> Mage::helper('custom')->__('Remove Kittedout'),
					 'url'  => $this->getUrl('*/adminhtml_kittedout/massRemove'),
					 'confirm' => Mage::helper('custom')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray1()
		{
            $data_array=array(); 
			$data_array[0]='Woman';
			$data_array[1]='Man';
            return($data_array);
		}
		static public function getValueArray1()
		{
            $data_array=array();
			foreach(Mac_Custom_Block_Adminhtml_Kittedout_Grid::getOptionArray1() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}