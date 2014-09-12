<?php
/**
 * Event observer model
 */
class Osdave_OrdersGrid_Model_Observer
{
    /**
     * Adds virtual grid column to order grid records generation
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function addColumnToResource(Varien_Event_Observer $observer)
    {
        $resource = $observer->getEvent()->getResource();
        $resource->addVirtualGridColumn(
            'payment_method',
            'sales/order_payment',
            array('entity_id' => 'parent_id'),
            'method'
        );
    }
}