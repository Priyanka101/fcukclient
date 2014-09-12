<?php
/**
 * Event observer model
 *
 *
 */
class Iksula_Customgridexport_Model_Observer
{
    /**
     * Adds virtual grid column to order grid records generation
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function addColumnToResource(Varien_Event_Observer $observer)
    {
        /* @var $resource Mage_Sales_Model_Mysql4_Order */
        $resource = $observer->getEvent()->getResource();
        $resource->addVirtualGridColumn(
            'customer_telephone',
            'sales/order_address',
            array('billing_address_id' => 'entity_id'),
            'telephone'
        );
    }
}