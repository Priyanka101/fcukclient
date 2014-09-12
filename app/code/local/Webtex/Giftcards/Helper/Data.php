<?php
class Webtex_Giftcards_Helper_Data extends Mage_Core_Helper_Data
{
    // For compatibility with Magento 1.4
    const XML_NODE_RELATED_CACHE = 'global/catalogrule/related_cache_types';
    public function applyAllRulesToProduct($productId) {
        Mage::getResourceModel('catalogrule/rule')->applyAllRulesForDateRange(NULL, NULL, $productId);
        $types = Mage::getConfig()->getNode(self::XML_NODE_RELATED_CACHE);
        if ($types) {
            $types = $types->asArray();
            Mage::app()->getCacheInstance()->invalidateType(array_keys($types));
        }
        $indexProcess = Mage::getSingleton('index/indexer')->getProcessByCode('catalog_product_price');
        if ($indexProcess) {
            $indexProcess->reindexAll();
        }
    }
}
