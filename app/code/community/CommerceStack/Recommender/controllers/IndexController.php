<?php
class CommerceStack_Recommender_IndexController extends Mage_Adminhtml_Controller_Action
{
	public function updateAction()
    {      
        session_write_close(); // prevent other requests from blocking during update because of locked session file
        //ini_set('memory_limit', '512M');
        set_time_limit(7200);
        $dataHelper = Mage::helper('recommender');
        $currentTask = 1;
        
        try
        {
           $dataHelper->setClientStatus('transferring');
            //$dataHelper->setTotalTasks(68);
            $dataHelper->setTotalTasks(7);
             
            // Basic analysis
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('sales/order_grid'), 'entity_id', 'order', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('sales/order_item'), 'item_id', 'orderitem', 1000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('log/customer'), 'log_id', 'logcustomer', 10000);
        	$currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('log/url_info_table'), 'url_id', 'logurlinfo', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('log/url_table'), 'url_id', 'logurl', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postRecordset('v.entity_id as product_id, v.value as url_path', (string)Mage::getConfig()->getTablePrefix() . 'catalog_product_entity_varchar v' , "INNER JOIN " . $dataHelper->getTableNameSafe('eav/attribute') . " eav ON v.attribute_id = eav.attribute_id AND eav.attribute_code='url_path'", '', 'entity_id', 'producturl', 5000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postRecordset('*', $dataHelper->getTableNameSafe('core/url_rewrite'), '', 'WHERE product_id IS NOT null', 'url_rewrite_id', 'urlrewrite', 5000);
            $currentTask++;
            
            $productLinks = Mage::getModel('recommender/product_link');
        	$productLinks->update();
        	
        	$dataHelper->setClientStatus('complete');
            
            // Continue advanced analysis
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('reports/viewed_product_index'), 'index_id', 'viewedproduct', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('reports/compared_product_index'), 'index_id', 'comparedproduct', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('wishlist/wishlist'), 'wishlist_id', 'wishlist', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('wishlist/item'), 'wishlist_item_id', 'wishlistitem', 10000);
     		$currentTask++;
            
        	$dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('sendfriend/sendfriend'), 'log_id', 'sendfriend', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('tag/tag'), 'tag_id', 'tag', 10000);
            $currentTask++;
            
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('tag/properties'), 'tag_id', 'tagproperty', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('tag/relation'), 'tag_relation_id', 'tagrelation', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('tag/summary'), 'tag_id', 'tagsummary', 10000);
            $currentTask++;
            
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('rating/rating'), 'rating_id', 'rating', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('rating/rating_entity'), 'entity_id', 'ratingentity', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('rating/rating_option'), 'option_id', 'ratingoption', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('rating/rating_option_vote'), 'vote_id', 'ratingoptionvote', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('rating/rating_vote_aggregated'), 'primary_id', 'ratingoptionvoteaggregated', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('rating/rating_store'), 'rating_id', 'ratingstore', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('rating/rating_title'), 'rating_id', 'ratingtitle', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('review/review'), 'review_id', 'review', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('review/review_detail'), 'detail_id', 'reviewdetail', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('review/review_entity'), 'entity_id', 'reviewentity', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('review/review_aggregate'), 'primary_id', 'reviewentitysummary', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('review/review_status'), 'status_id', 'reviewstatus', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('review/review_store'), 'review_id', 'reviewstore', 10000);
            $currentTask++;
            
            // Excluding personally identifiable information (email address)
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('subscriber_id, store_id, change_status_at, customer_id, subscriber_status', $dataHelper->getTableNameSafe('newsletter/subscriber'), 'subscriber_id', 'newslettersubscriber', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalogsearch/fulltext'), 'product_id', 'catalogsearchfulltext', 1000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalogsearch/search_query'), 'query_id', 'catalogsearchquery', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalogsearch/result'), 'query_id', 'catalogsearchresult', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalogrule/rule'), 'rule_id', 'catalogrule', 5000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalogrule/rule_group_website'), 'rule_id', 'catalogrulegroupwebsite', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalogrule/rule_product'), 'rule_product_id', 'catalogruleproduct', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalogrule/rule_product_price'), 'rule_product_price_id', 'catalogruleproductprice', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('salesrule/rule'), 'rule_id', 'salesrule', 5000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('salesrule/coupon'), 'coupon_id', 'salesrulecoupon', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('salesrule/coupon_usage'), 'coupon_id', 'salesrulecouponusage', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('salesrule/rule_customer'), 'rule_customer_id', 'salesrulecustomer', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('salesrule/label'), 'label_id', 'salesrulelabel', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('salesrule/product_attribute'), 'rule_id', 'salesruleproductattribute', 10000);
            $currentTask++;

            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('eav/attribute'), 'attribute_id', 'eavattribute', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/category'), 'entity_id', 'catalogcategory', 10000);
            $currentTask++;

        	$dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/category') . '_datetime', 'value_id', 'catalogcategorydatetime', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/category') . '_decimal', 'value_id', 'catalogcategorydecimal', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/category') . '_int', 'value_id', 'catalogcategoryint', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/category') . '_text', 'value_id', 'catalogcategorytext', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/category') . '_varchar', 'value_id', 'catalogcategoryvarchar', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/category_product'), 'category_id', 'catalogcategoryproduct', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/eav_attribute'), 'attribute_id', 'catalogeavattribute', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/product'), 'entity_id', 'catalogproduct', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/product') . '_datetime', 'value_id', 'catalogproductdatetime', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/product') . '_decimal', 'value_id', 'catalogproductdecimal', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/product') . '_gallery', 'value_id', 'catalogproductgallery', 10000);
            $currentTask++;

            /* 1.7.0 only
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/product') . '_group_price', 'value_id', 'catalogproductgroupprice', 10000);
            $currentTask++;
            */
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/product') . '_int', 'value_id', 'catalogproductint', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/product') . '_media_gallery', 'value_id', 'catalogproductmediagallery', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/product') . '_media_gallery_value', 'value_id', 'catalogproductmediagalleryvalue', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/product') . '_text', 'value_id', 'catalogproducttext', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/product') . '_tier_price', 'value_id', 'catalogproducttierprice', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/product') . '_varchar', 'value_id', 'catalogproductvarchar', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/product_relation'), 'parent_id', 'catalogproductrelation', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/product_super_attribute'), 'product_super_attribute_id', 'catalogproductsuperattribute', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/product_super_attribute_label'), 'value_id', 'catalogproductsuperattributelabel', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/product_super_attribute_pricing'), 'value_id', 'catalogproductsuperattributepricing', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('catalog/product_super_link'), 'link_id', 'catalogproductsuperlink', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('log/visitor'), 'visitor_id', 'logvisitor', 10000);
            $currentTask++;
            
            $dataHelper->setCurrentTask($currentTask);
            $dataHelper->postUpdate('*', $dataHelper->getTableNameSafe('log/visitor_info'), 'visitor_id', 'logvisitorinfo', 10000);
            $currentTask++;
            
            $dataHelper->setClientStatus('complete'); // Send again to reset task values
            $this->getResponse()->setBody("");
        }
        catch(Exception $e)
        {
            $dataHelper->reportException($e);
        }
    }
}