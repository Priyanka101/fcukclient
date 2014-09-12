<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml sales orders grid
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Adminhtml_Block_Sales_Order_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {	
        parent::__construct();
        $this->setId('sales_order_grid');
        $this->setUseAjax(true);
        $this->setDefaultSort('entity_id');
       // $this->setDefaultDir('DESC');
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
		
		$collection->getSelect()->joinLeft('sales_flat_order_address', '(main_table.entity_id= sales_flat_order_address.parent_id && sales_flat_order_address.address_type="shipping")', array('postcode'));
        $collection->getSelect()->joinLeft('sales_flat_order', 'main_table.increment_id = sales_flat_order.increment_id', 'sales_flat_order.customer_email as customer_email');
        $collection->getSelect()->joinLeft('sales_flat_order_payment', 'main_table.entity_id = sales_flat_order_payment.parent_id', 'sales_flat_order_payment.method as payment_method');
		$text = Mage::getStoreConfig('store/carrier/carrierinfo');
        if($text=='1'){
              $collection->getSelect()->joinLeft('order_ship_track', 'main_table.entity_id = order_ship_track.order_id', 'order_ship_track.carrier as carrier');
        }
        /* ------carrier filter
        $collection->getSelect()->joinLeft('order_ship_track', 'main_table.entity_id = order_ship_track.order_id', 'order_ship_track.carrier as carrier');
		*/
        $collection = $collection->setOrder('entity_id', 'desc');
		//$collection = $collection->setOrder('DESC');
		//$collection->getSelect()->joinLeft('sales_flat_order_address', '(main_table.entity_id= sales_flat_order_address.parent_id && sales_flat_order_address.address_type="shipping")', array('postcode'));
        //$collection->getSelect()->group('main_table.entity_id');
		//$collection->printLogQuery(true);
		//echo $collection->getSelect();
		//exit;
		
        //Mage::log($collection->getSelect()->__toString());
		
        $this->setCollection($collection);
        return parent::_prepareCollection();
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
		
		 $this->addColumn('carrier', array(
            'header'=> Mage::helper('sales')->__('shipping carrier'),
            'width' => '80px',
            'type'  => 'text',
			'filter_index' => 'order_ship_track.carrier',
            'index' => 'carrier',
        ));
		

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'    => Mage::helper('sales')->__('Purchased From (Store)'),
                'index'     => 'store_id',
                'type'      => 'store',
                'store_view'=> true,
                'display_deleted' => false,
				'filter_index' => 'main_table.store_id',
            ));
        }

        $this->addColumn('created_at', array(
            'header' => Mage::helper('sales')->__('Purchased On'),
            'index' => 'created_at',
			'filter_index' => 'main_table.created_at',
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
		
		 $this->addColumn('postcode', array(
            'header' => Mage::helper('sales')->__('Pin Code'),
            'index' => 'postcode',
			'filter'    => false,
        ));
		
        $this->addColumn('base_grand_total', array(
            'header' => Mage::helper('sales')->__('G.T. (Base)'),
            'index' => 'base_grand_total',
			'filter_index' => 'main_table.base_grand_total',
            'type'  => 'currency',
            'currency' => 'base_currency_code',
        ));

        $this->addColumn('grand_total', array(
            'header' => Mage::helper('sales')->__('G.T. (Purchased)'),
            'index' => 'grand_total',
			'filter_index' => 'main_table.grand_total',
            'type'  => 'currency',
            'currency' => 'order_currency_code',
        ));
		
		$this->addColumn('payment_method', array(
            'header' => Mage::helper('sales')->__('Payment Method'),
            'index' => 'payment_method',
            'filter_index' => 'sales_flat_order_payment.method',
            'type'  => 'options',
            'width' => '70px',
            'options' => $this->getAllPaymentMethods(),
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('sales')->__('Status'),
            'index' => 'status',
			'filter_index' => 'main_table.status',
            'type'  => 'options',
            'width' => '70px',
            'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
        ));
		
		/*for temp_status update for tracking in shiptrack table*/
			$resource = Mage::getSingleton('core/resource');
			$read = $resource->getConnection('core_read');
			$query = "UPDATE shiptrack SET temp_status = 0";
			$result=$read->query($query);
		

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

        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel XML'));

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

       /* if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/cancel')) {
            $this->getMassactionBlock()->addItem('cancel_order', array(
                 'label'=> Mage::helper('sales')->__('Cancel'),
                 'url'  => $this->getUrl('*//*sales_order/massCancel'),
            ));
        }

        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/hold')) {
            $this->getMassactionBlock()->addItem('hold_order', array(
                 'label'=> Mage::helper('sales')->__('Hold'),
                 'url'  => $this->getUrl('*//*sales_order/massHold'),
            ));
        }

        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/unhold')) {
            $this->getMassactionBlock()->addItem('unhold_order', array(
                 'label'=> Mage::helper('sales')->__('Unhold'),
                 'url'  => $this->getUrl('*//*sales_order/massUnhold'),
            ));
        }*/
		

        $this->getMassactionBlock()->addItem('simpleorderexport', array(
             'label'=> Mage::helper('sales')->__('Export to .csv file'),
             'url'  => $this->getUrl('simpleorderexport/export_order/csvexport'),
        ));
		
		 $this->getMassactionBlock()->addItem('softcopyexport', array(
             'label'=> Mage::helper('sales')->__('Export soft copy to .csv file'),
             'url'  => $this->getUrl('simpleorderexport/export_order/softcopycsvexport'),
        ));
		
		$this->getMassactionBlock()->addItem('dispatchdataexport', array(
             'label'=> Mage::helper('sales')->__('Dispatch Data to .csv file'),
             'url'  => $this->getUrl('simpleorderexport/export_order/dispatchdataexport'),
        ));
		
		$this->getMassactionBlock()->addItem('pendingreportexport', array(
             'label'=> Mage::helper('sales')->__('Pending Order to .csv file'),
             'url'  => $this->getUrl('simpleorderexport/export_order/pendingreportexport'),
        ));
		
		$this->getMassactionBlock()->addItem('salesreportexport', array(
             'label'=> Mage::helper('sales')->__('Sales Report to .csv file'),
             'url'  => $this->getUrl('simpleorderexport/export_order/salesreportexport'),
        ));
		
		$this->getMassactionBlock()->addItem('returnreportexport', array(
             'label'=> Mage::helper('sales')->__('Return Report to .csv file'),
             'url'  => $this->getUrl('simpleorderexport/export_order/returnreportexport'),
        ));
		
		
		$this->getMassactionBlock()->addItem('discountreportexport', array(
             'label'=> Mage::helper('sales')->__('Discount report to .csv file'),
             'url'  => $this->getUrl('simpleorderexport/export_order/discountreportexport'),
        ));

		 $this->getMassactionBlock()->addItem('finacereportexport', array(
             'label'=> Mage::helper('sales')->__('Finance report to .csv file'),
             'url'  => $this->getUrl('simpleorderexport/export_order/finacereportexport'),
        )); 
		
		
		 $this->getMassactionBlock()->addItem('assigntracking', array(
             'label'=> Mage::helper('sales')->__('Assingn Tracking'),
             'url'  => $this->getUrl('simpleorderexport/export_order/assingTracking'),
        ));

    	
		
	 $this->getMassactionBlock()->addItem('manifest_Pdf', array(
             'label'=> Mage::helper('sales')->__('Manifest Pdf'),
             'url'  => $this->getUrl('simpleorderexport/export_order/manifestPdf'),
        ));	
		
		/*delete orders option*/
/*		$this->getMassactionBlock()->addItem('-', array(
             'label'=> Mage::helper('sales')->__('----------------------'),
             'url'  => $this->getUrl('-'),
        ));
		
		 $this->getMassactionBlock()->addItem('--', array(
             'label'=> Mage::helper('sales')->__(''),
             'url'  => $this->getUrl('--'),
        ));
		
		 $this->getMassactionBlock()->addItem('delete_order', array(
             'label'=> Mage::helper('sales')->__('Delete order'),
             'url'  => $this->getUrl('simpleorderexport/export_order/deleteorder'),
             'confirm'  => Mage::helper('sales')->__('Are you sure you want to delete order?')
        ));
		
		 $this->getMassactionBlock()->addItem('---', array(
             'label'=> Mage::helper('sales')->__(''),
             'url'  => $this->getUrl('---'),
        ));
		*/
		/*delete orders option*/
			
    
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
