<?php 
class Amasty_Oaction_Block_Adminhtml_Sales_Order_Grid extends SLandsbek_SimpleOrderExport_Block_Sales_Order_Grid
{

 public function __construct()
    {
        parent::__construct();
        $this->setId('sales_order_grid');
        $this->setUseAjax(true);
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setOptimizedFilterColumn(array('real_order_id','billing_name'));
        Mage::register('fixOrderCount', true);
    }
	 /**
     * Retrieve collection class
     *
     * @return string
     */
    protected function _getCollectionClass()
    {
        return 'sales/order_grid_collection';
    }

 protected function _prepareCollection()
    {
		
        $collection = Mage::getResourceModel($this->_getCollectionClass());
		//print_r(get_class($collection));exit;
		$collection->getSelect()->joinLeft('sales_flat_shipment_track','main_table.entity_id = sales_flat_shipment_track.order_id ', array('track_number'));
		$collection->getSelect()->joinLeft('sales_flat_order_item','main_table.entity_id = sales_flat_order_item.order_id ', array('sku'));
		$collection->getSelect()->joinLeft('sales_flat_order_address','main_table.entity_id = sales_flat_order_address.parent_id  ', array('CONCAT(street, ", ", city, ", ", region, ", ", postcode, ", ", country_id) AS delivery_address'));
		$collection->getSelect()->joinLeft('sales_flat_order_payment','main_table.entity_id = sales_flat_order_payment.parent_id   GROUP BY main_table.entity_id ORDER BY main_table.increment_id DESC ', 'sales_flat_order_payment.method as payment_method');
		//$collection->printlogquery(true);
		//Mage::log($collection->getSelect()->__toString());
	  
		// exit;
        $this->setCollection($collection);
       
    }
   
     protected function _prepareColumns()
    {
		
        $this->addColumn('real_order_id', array(
            'header'=> Mage::helper('sales')->__('Order #'),
            'width' => '80px',
            'type'  => 'text',
            'filter_index' => 'main_table.increment_id',
            'index' => 'increment_id',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'    => Mage::helper('sales')->__('Purchased From (Store)'),
                'index'     => 'store_id',
                'type'      => 'store',
                'store_view'=> true,
                'display_deleted' => true,
            ));
        }

        $this->addColumn('created_at', array(
            'header' => Mage::helper('sales')->__('Purchased On'),
            'index' => 'created_at',
            'type' => 'datetime',
            'width' => '100px',
        ));

        $this->addColumn('billing_name', array(
            'header' => Mage::helper('sales')->__('Bill to Name'),
            'index' => 'billing_name',
        ));

        $this->addColumn('shipping_name', array(
            'header' => Mage::helper('sales')->__('Ship to Name'),
            'index' => 'shipping_name',
        ));
		  
		
		$this->addColumn('track_number', array(
            'header' => Mage::helper('sales')->__('Track Number'),
            'index' => 'track_number',
        ));
		
		$this->addColumn('sku', array(
            'header' => Mage::helper('sales')->__('SKU'),
            'index' => 'sku',
        ));	
		
		$this->addColumn('delivery_address', array(
            'header' => Mage::helper('sales')->__('Delivery Address'),
            'index' => 'delivery_address',
			'width'     => '50px',
        ));
		
        $this->addColumn('base_grand_total', array(
            'header' => Mage::helper('sales')->__('G.T. (Base)'),
            'index' => 'base_grand_total',
            'type'  => 'currency',
            'currency' => 'base_currency_code',
        ));

        $this->addColumn('grand_total', array(
            'header' => Mage::helper('sales')->__('G.T. (Purchased)'),
            'index' => 'grand_total',
            'type'  => 'currency',
            'currency' => 'order_currency_code',
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('sales')->__('Status'),
            'index' => 'status',
            'type'  => 'options',
            'width' => '70px',
            'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
			'filter_condition_callback'
                                => array($this, '_filterStatusCondition'),
        ));
		  $this->addColumn('payment_method', array(
            'header' => Mage::helper('sales')->__('Payment Method'),
            'index' => 'payment_method',
            'filter_index' => 'sales_flat_order_payment.method',
            'type'  => 'options',
            'width' => '70px',
            'options' => $this->getAllPaymentMethods(),
        ));

        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
            $this->addColumn('action',
                array(
                    'header'    => Mage::helper('sales')->__('Action'),
                    'width'     => '50px',
                    'type'      => 'action',
                    'getter'     => 'getId',
                    'actions'   => array(
                        array(
                            'caption' => Mage::helper('sales')->__('View'),
                            'url'     => array('base'=>'*/sales_order/view'),
                            'field'   => 'order_id'
                        )
                    ),
                    'filter'    => false,
                    'sortable'  => false,
                    'index'     => 'stores',
                    'is_system' => true,
            ));
        }
        $this->addRssList('rss/order/new', Mage::helper('sales')->__('New Order RSS'));

        //$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel XML'));

        return parent::_prepareColumns();
    }
	  protected function _afterLoadCollection() {
        unset($this->_columns['entity_id']);
        return parent::_afterLoadCollection();
    }
	protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('order_ids');
        $this->getMassactionBlock()->setUseSelectAll(true);

        $this->getMassactionBlock()->addItem('simpleorderexport', array(
             'label'=> Mage::helper('sales')->__('Export to .csv file'),
             'url'  => $this->getUrl('*/simpleorderexport/export_order/csvexport'),
        ));

     

        return $this;
    }
	public function getRowUrl($row)
    {
        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
            return $this->getUrl('*/sales_order/view', array('order_id' => $row->getId()));
        }
        return false;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
	/*
	protected function _filterStatusCondition($collection, $column)
{
	if (!$value = $column->getFilter()->getValue()) {
		return;
	}

	$this->getCollection()->addFieldToFilter('status', array('eq' => $value));
}*/
 public function getAllPaymentMethods()
    {
       $payments = Mage::getSingleton('payment/config')->getAllMethods();

       $methods = array();

       foreach ($payments as $paymentCode=>$paymentModel) {
            $paymentTitle = Mage::getStoreConfig('payment/'.$paymentCode.'/title');
            $methods[$paymentCode] = $paymentTitle;
        }

        return $methods;

    }
	
}
?>