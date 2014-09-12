<?php

class Fcuk_Outwardregister_Block_Adminhtml_Outwardregister_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('outwardregisterGrid');
      $this->setDefaultSort('outwardregister_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('outwardregister/outwardregister')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('outwardregister_id', array(
          'header'    => Mage::helper('outwardregister')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'outwardregister_id',
      ));

     $this->addColumn('transaction_type', array(
          'header'    => Mage::helper('outwardregister')->__('Transaction Type'),
          'align'     =>'left',
          'index'     => 'transaction_type',
      ));
	  
	   $this->addColumn('chainstore', array(
          'header'    => Mage::helper('outwardregister')->__('Party'),
          'align'     =>'left',
          'index'     => 'chainstore',
      ));
	  
	   $this->addColumn('reasoncode', array(
          'header'    => Mage::helper('outwardregister')->__('Reason Code'),
          'align'     =>'left',
          'index'     => 'reasoncode',
      ));
	  
	   $this->addColumn('refdcno', array(
          'header'    => Mage::helper('outwardregister')->__('Ref DC No'),
          'align'     =>'left',
          'index'     => 'refdcno',
      ));
	  
	   $this->addColumn('dc_date', array(
          'header'    => Mage::helper('outwardregister')->__('Dc Date'),
          'align'     =>'left',
          'index'     => 'dc_date',
      ));
	  
	   $this->addColumn('doc_remarks', array(
          'header'    => Mage::helper('outwardregister')->__('Doc Remarks'),
          'align'     =>'left',
          'index'     => 'doc_remarks',
      ));
	  
	   $this->addColumn('doc_prefix', array(
          'header'    => Mage::helper('outwardregister')->__('Doc Prefix'),
          'align'     =>'left',
          'index'     => 'doc_prefix',
      ));
	  
	   $this->addColumn('doc_number', array(
          'header'    => Mage::helper('outwardregister')->__('Doc Number'),
          'align'     =>'left',
          'index'     => 'doc_number',
      ));
	  
	   $this->addColumn('created_time', array(
          'header'    => Mage::helper('outwardregister')->__('Outward Created'),
          'align'     =>'left',
          'index'     => 'created_time',
      ));
	  
/*
      $this->addColumn('status', array(
          'header'    => Mage::helper('outwardregister')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      )); */
	  
	  /*
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('outwardregister')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('outwardregister')->__('Edit'),
                        'url'       => array('base'=> '//edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        )); */
		
		$this->addExportType('*/*/exportCsv', Mage::helper('outwardregister')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('outwardregister')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('outwardregister_id');
        $this->getMassactionBlock()->setFormFieldName('outwardregister');

/*        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('outwardregister')->__('Delete'),
             'url'      => $this->getUrl('//massDelete'),
             'confirm'  => Mage::helper('outwardregister')->__('Are you sure?')
        ));
*/
        $statuses = Mage::getSingleton('outwardregister/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
   /*     $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('outwardregister')->__('Change status'),
             'url'  => $this->getUrl('//massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('outwardregister')->__('Status'),
                         'values' => $statuses
                     )
             )
        )); */
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	 // return '';
  }

}