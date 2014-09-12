<?php

class Fcuk_Content_Block_Adminhtml_Gamechanger_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("gamechangerGrid");
				$this->setDefaultSort("gamechangerid");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("content/gamechanger")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("gamechangerid", array(
				"header" => Mage::helper("content")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "gamechangerid",
				));
                
						$this->addColumn('slideno', array(
						'header' => Mage::helper('content')->__('Slide No'),
						'index' => 'slideno',
						'type' => 'options',
						'options'=>Iksula_Content_Block_Adminhtml_Gamechanger_Grid::getOptionArray1(),				
						));
						
						$this->addColumn('type', array(
						'header' => Mage::helper('content')->__('Banner Type'),
						'index' => 'type',
						'type' => 'options',
						'options'=>Iksula_Content_Block_Adminhtml_Gamechanger_Grid::getOptionArray2(),				
						));

						$this->addColumn("image1", array(
						"header" => Mage::helper("content")->__("Image 1"),
						"index" => "image1",
						"renderer" =>"Iksula_Content_Block_Adminhtml_Renderer_Image",
						));

						
						$this->addColumn("image2", array(
						"header" => Mage::helper("content")->__("Image 2"),
						"index" => "image2",
						"renderer" =>"Iksula_Content_Block_Adminhtml_Renderer_Image",
						));


						$this->addColumn("image3", array(
						"header" => Mage::helper("content")->__("Image 3"),
						"index" => "image3",
						"renderer" =>"Iksula_Content_Block_Adminhtml_Renderer_Image",
						));


						$this->addColumn("image4", array(
						"header" => Mage::helper("content")->__("Image 4"),
						"index" => "image4",
						"renderer" =>"Iksula_Content_Block_Adminhtml_Renderer_Image",
						));


						$this->addColumn("image5", array(
						"header" => Mage::helper("content")->__("Image 5"),
						"index" => "image5",
						"renderer" =>"Iksula_Content_Block_Adminhtml_Renderer_Image",
						));


						$this->addColumn("image6", array(
						"header" => Mage::helper("content")->__("Image 6"),
						"index" => "image6",
						"renderer" =>"Iksula_Content_Block_Adminhtml_Renderer_Image",
						));


	/*			$this->addColumn("name1", array(
				"header" => Mage::helper("content")->__("Name 1"),
				"index" => "name1",
				));
				$this->addColumn("name2", array(
				"header" => Mage::helper("content")->__("Name 2"),
				"index" => "name2",
				));
				$this->addColumn("name3", array(
				"header" => Mage::helper("content")->__("Name 3"),
				"index" => "name3",
				));
				$this->addColumn("name4", array(
				"header" => Mage::helper("content")->__("Name 4"),
				"index" => "name4",
				));
				$this->addColumn("name5", array(
				"header" => Mage::helper("content")->__("Name 5"),
				"index" => "name5",
				));
				$this->addColumn("name6", array(
				"header" => Mage::helper("content")->__("Name 6"),
				"index" => "name6",
				));
				$this->addColumn("url1", array(
				"header" => Mage::helper("content")->__("URL 1"),
				"index" => "url1",
				));
				$this->addColumn("url2", array(
				"header" => Mage::helper("content")->__("URL 2"),
				"index" => "url2",
				));
				$this->addColumn("url3", array(
				"header" => Mage::helper("content")->__("URL 3"),
				"index" => "url3",
				));
				$this->addColumn("url4", array(
				"header" => Mage::helper("content")->__("URL 4"),
				"index" => "url4",
				));
				$this->addColumn("url5", array(
				"header" => Mage::helper("content")->__("URL 5"),
				"index" => "url5",
				));
				$this->addColumn("url6", array(
				"header" => Mage::helper("content")->__("URL 6"),
				"index" => "url6",
				));*/
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
			$this->setMassactionIdField('gamechangerid');
			$this->getMassactionBlock()->setFormFieldName('gamechangerids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_gamechanger', array(
					 'label'=> Mage::helper('content')->__('Remove Gamechanger'),
					 'url'  => $this->getUrl('*/adminhtml_gamechanger/massRemove'),
					 'confirm' => Mage::helper('content')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray1()
		{
            $data_array=array(); 
			$data_array[0]='1';
			$data_array[1]='2';
			$data_array[2]='3';
			$data_array[3]='4';
			$data_array[4]='5';
            return($data_array);
		}
		static public function getValueArray1()
		{
            $data_array=array();
			foreach(Iksula_Content_Block_Adminhtml_Gamechanger_Grid::getOptionArray1() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
		static public function getOptionArray2()
		{
            $data_array=array(); 
			$data_array[0]='Single Banner';
			$data_array[1]='Multi Banner(3/1/2)';
			$data_array[2]='Multi Banner(2/1/3)';
			$data_array[3]='Multi Banner(1/3/2)';
            return($data_array);
		}
		static public function getValueArray2()
		{
            $data_array=array();
			foreach(Iksula_Content_Block_Adminhtml_Gamechanger_Grid::getOptionArray2() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}