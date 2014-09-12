<?php

class Fcuk_Inwardregister_Block_Adminhtml_Inwardregister_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('inwardregisterGrid');
      $this->setDefaultSort('inwardregister_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('inwardregister/inwardregister')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('inwardregister_id', array(
          'header'    => Mage::helper('inwardregister')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'inwardregister_id',
      ));

      $this->addColumn('transaction_type', array(
          'header'    => Mage::helper('inwardregister')->__('Transaction Type'),
          'align'     =>'left',
          'index'     => 'transaction_type',
      ));
	  
	   $this->addColumn('chainstore', array(
          'header'    => Mage::helper('inwardregister')->__('Party'),
          'align'     =>'left',
          'index'     => 'chainstore',
      ));
	  
	   $this->addColumn('reasoncode', array(
          'header'    => Mage::helper('inwardregister')->__('Reason Code'),
          'align'     =>'left',
          'index'     => 'reasoncode',
      ));
	  
	   $this->addColumn('refdcno', array(
          'header'    => Mage::helper('inwardregister')->__('Ref DC No'),
          'align'     =>'left',
          'index'     => 'refdcno',
      ));
	  
	   $this->addColumn('dc_date', array(
          'header'    => Mage::helper('inwardregister')->__('Dc Date'),
          'align'     =>'left',
          'index'     => 'dc_date',
      ));
	  
	   $this->addColumn('doc_remarks', array(
          'header'    => Mage::helper('inwardregister')->__('Doc Remarks'),
          'align'     =>'left',
          'index'     => 'doc_remarks',
      ));
	  
	   $this->addColumn('doc_prefix', array(
          'header'    => Mage::helper('inwardregister')->__('Doc Prefix'),
          'align'     =>'left',
          'index'     => 'doc_prefix',
      ));
	  
	   $this->addColumn('doc_number', array(
          'header'    => Mage::helper('inwardregister')->__('Doc Number'),
          'align'     =>'left',
          'index'     => 'doc_number',
      ));
	  
	   $this->addColumn('created_time', array(
          'header'    => Mage::helper('inwardregister')->__('Inward Created'),
          'align'     =>'left',
          'index'     => 'created_time',
      ));
	  
	  
	  
	  

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('inwardregister')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */
/*
	 $this->addColumn('status', array(
          'header'    => Mage::helper('inwardregister')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
             'Purchease' => 'Purchease',
              'Transferin' => 'Transferin',
			  'Adjustment' => 'Adjustment',
          ),
      )); */
     /* $this->addColumn('status', array(
          'header'    => Mage::helper('inwardregister')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));*/
	 /* 
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('inwardregister')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('inwardregister')->__('Edit'),
                        'url'       => array('base'=> '//edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		*/
		$this->addExportType('*/*/exportCsv', Mage::helper('inwardregister')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('inwardregister')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('inwardregister_id');
        $this->getMassactionBlock()->setFormFieldName('inwardregister');

      /*  $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('inwardregister')->__('Delete'),
             'url'      => $this->getUrl('//massDelete'),
             'confirm'  => Mage::helper('inwardregister')->__('Are you sure?')
        )); */

        $statuses = Mage::getSingleton('inwardregister/status')->getOptionArray();
		

        array_unshift($statuses, array('label'=>'', 'value'=>''));
		
		/*
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('inwardregister')->__('Change status'),
             'url'  => $this->getUrl('//massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('inwardregister')->__('Status'),
                         'values' => $statuses
                     )
             )
        )); */
		/*
		$this->getMassactionBlock()->addItem('movetolive', array(
             'label'=> Mage::helper('inwardregister')->__('Move To Live'),
             'url'  => $this->getUrl('//massMovetolive', array('_current'=>true)),
         
        ));*/
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	  
  }

}