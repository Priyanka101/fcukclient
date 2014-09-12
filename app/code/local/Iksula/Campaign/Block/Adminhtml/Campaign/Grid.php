<?php

class Iksula_Campaign_Block_Adminhtml_Campaign_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("campaignGrid");
				$this->setDefaultSort("campaign_id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("campaign/campaign")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("campaign_id", array(
				"header" => Mage::helper("campaign")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "campaign_id",
				));
                
				$this->addColumn("email_address", array(
				"header" => Mage::helper("campaign")->__("Email"),
				"index" => "email_address",
				));
				$this->addColumn("prefix", array(
				"header" => Mage::helper("campaign")->__("Prefix"),
				"index" => "prefix",
				));
				$this->addColumn("firstname", array(
				"header" => Mage::helper("campaign")->__("First Name"),
				"index" => "firstname",
				));
				$this->addColumn("lastname", array(
				"header" => Mage::helper("campaign")->__("Last Name"),
				"index" => "lastname",
				));
						$this->addColumn('gender', array(
						'header' => Mage::helper('campaign')->__('Gender'),
						'index' => 'gender',
						'type' => 'options',
						'options'=>Iksula_Campaign_Block_Adminhtml_Campaign_Grid::getOptionArray5(),				
						));
						
					$this->addColumn('customerdob', array(
						'header'    => Mage::helper('campaign')->__('Date of Birth'),
						'index'     => 'customerdob',
						'type'      => 'date',
					));
				$this->addColumn("telephoneno", array(
				"header" => Mage::helper("campaign")->__("Telephone"),
				"index" => "telephoneno",
				));
				$this->addColumn("mobileno", array(
				"header" => Mage::helper("campaign")->__("Mobile"),
				"index" => "mobileno",
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
			$this->setMassactionIdField('campaign_id');
			$this->getMassactionBlock()->setFormFieldName('campaign_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_campaign', array(
					 'label'=> Mage::helper('campaign')->__('Remove Campaign'),
					 'url'  => $this->getUrl('*/adminhtml_campaign/massRemove'),
					 'confirm' => Mage::helper('campaign')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray5()
		{
            $gender = array();
			$options = Mage::getResourceSingleton('customer/customer')->getAttribute('gender')->getSource()->getAllOptions();
			foreach ($options as $option){
				if($option['label']!=""){
					$gender[$option['value']] = $option['label'];
				}
			}
			return $gender ;   
		}
		static public function getValueArray5()
		{
            
			$gender = array();
			$options = Mage::getResourceSingleton('customer/customer')->getAttribute('gender')->getSource()->getAllOptions();
			foreach ($options as $key => $value ){
				if($key['label']!=""){
					$gender[] = array('value'=>$key,'label'=>$value);
				}
			}
			return $gender ; 
		}
		

}