<?php
class CommerceStack_Recommender_Model_AdminNotification_Feed extends Mage_AdminNotification_Model_Feed
{
    public function getFeedData()
    {
        try 
        {
            $xml = parent::getFeedData();
            if ($xml === false) 
            {
                return false;
            }
        
            $client = Mage::helper('recommender/pest');
            $client->curl_opts[CURLOPT_TIMEOUT] = 3; // Don't hang login if server is down
            $commercestackXml = $client->get('notification/');
            
            if(!$commercestackXml) return $xml;
            $commercestackXml = simplexml_load_string($commercestackXml);
            foreach($commercestackXml as $notification)
            {
                $item = $xml->channel->addChild('item');
                foreach($notification as $name => $value)
                {
                    $item->addChild($name, $value);
                }
            }
        }
        catch(Exception $e)
        {
            $dataHelper = Mage::helper('recommender');
            $dataHelper->reportException($e);
        }
        
        return $xml;
    }
}