<?php
class CommerceStack_Recommender_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $_totalTasks;
    protected $_currentTask;
    
    protected function _appendAuthToUri($uri)
    {
        $apiUser = Mage::getStoreConfig('recommender/api_user');
        $apiSecret = Mage::getStoreConfig('recommender/api_secret');
        
        if(!($apiUser && $apiSecret))
        {
            $key = $this->_requestNewApiKey();
            $apiUser = $key['api_user'];
            $apiSecret = $key['api_secret'];
        }
        
        $query = parse_url($uri, PHP_URL_QUERY);

        if($query) 
        {
            $uri .= "&api_user=$apiUser&api_secret=$apiSecret";
        }
        else 
        {
            $uri .= "?api_user=$apiUser&api_secret=$apiSecret";
        }
        
        return $uri;
    }
    
    protected function _requestNewApiKey()
    {
        $unsecureBaseUrl = Mage::getStoreConfig('web/unsecure/base_url');
        $secureBaseUrl = Mage::getStoreConfig('web/secure/base_url');
        $mageVersion = Mage::getVersion();
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	    $xml .= "<account>\n";
	    $xml .= "<commercestack_recommender_version>{$this->_getRecommenderVersion()}</commercestack_recommender_version>\n";
	    $xml .= "<mage_version>$mageVersion</mage_version>\n";
	    $xml .= "<unsecure_base_url>$unsecureBaseUrl</unsecure_base_url>\n";
	    $xml .= "<secure_base_url>$secureBaseUrl</secure_base_url>\n";
	    $xml .= "</account>\n";
	    
	    $retries = 0;
        try 
		{
		    $client = Mage::helper('recommender/pest');
		    $response = $client->post("account/", $xml); 
		    
		    $xml = simplexml_load_string($response);
		    
		    if(!$xml) throw new Pest_ServerError('Server did not respond to account creation request.');
		    
		    $config = new Mage_Core_Model_Config();
		    $config->saveConfig('recommender/api_user', (string)$xml->api_user);
		    $config->saveConfig('recommender/api_secret', (string)$xml->api_secret);
		    Mage::getConfig()->cleanCache();
		    
		    return array('api_user' => (string)$xml->api_user, 'api_secret' => (string)$xml->api_secret);
		}
		catch(Pest_ServerError $e)
		{
		   $this->reportException($e);
		}

    }
    
    public function postRecordset($columns, $tables, $joins, $where, $primaryKey, $rootName, $chunkSize)
    {
        // Varien's ORM contains circular references which the PHP garbage collector cannot free. Since we may potentially be 
    	// pulling lots of data here we need to bypass Magento's collection classes
    	$i = 0;
        $retries = 0;
		$client = Mage::helper('recommender/pest');

		// Get total record count
		$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
		$countsql = "SELECT COUNT(*) as count FROM $tables $joins $where";
	    $result = $connection->query($countsql);
	    $totalRecordCount = $result->fetchColumn();
	    
	    $sql = "SELECT $columns FROM $tables $joins $where";
		
    	while(1)
    	{
    		$lowerLimit = $i*$chunkSize;
		    $chunkSql = $sql;

		    if($chunkSize > 0)
		    {
		        $chunkSql .= " ORDER BY $primaryKey ASC LIMIT " . $i*$chunkSize . ", $chunkSize";
		    }
		    
		    $result = $connection->fetchAll($chunkSql);
		    if(count($result) == 0) break;
		    
		    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
		    $xml .= "<{$rootName}s>\n";
		    $xml .= "<commercestack_recommender_version>{$this->_getRecommenderVersion()}</commercestack_recommender_version>\n";
		    $xml .= "<current_task>{$this->_currentTask}</current_task>\n";
		    $xml .= "<total_tasks>{$this->_totalTasks}</total_tasks>\n";
		    $xml .= "<current_frame>" . ($i+1) . "</current_frame>\n";
		    
		    $chunkSize == 0 ? $totalFrames = 1 : $totalFrames = ceil($totalRecordCount/$chunkSize);
		    $xml .= "<total_frames>" . $totalFrames . "</total_frames>\n";
		    
		    // We cannot rely on XMLWriter being available so we construct the XML manually
			foreach ($result as $row) 
			{	
			    $xml .= "	<$rootName>\n";
				foreach($row as $key => $value)
				{
				    $xml .= "		<" . $key . "><![CDATA[" . $value . "]]></" . $key . ">\n";
				}
				$xml .= "	</$rootName>\n";
			}
			
			$xml .= "</{$rootName}s>\n";
			
			$i++;
			
			try 
			{
                $uri = $this->_appendAuthToUri("{$rootName}/");
                $response = $client->post($uri, $xml); 
                
                try
                {
                   $xml = simplexml_load_string($response);
                }
                catch(Exception $e)
                {
                   throw new Exception($e->getMessage() . "response: $xml", $e->getCode());
                }
                
                foreach($xml as $item)
                {
                    if((string)$item->name == 'client_status' && (string)$item->value == 'cancelRequested')
                    {
                        exit(); // exit() is ok here because we are in an ajax request
                    }
                }
			    
			}
			catch(Pest_ServerError $e)
			{
			    $this->reportException($e);
			}
			
			if($chunkSize == 0) break;

    	}
    }
    
    public function postUpdate($columns, $table, $primaryKey, $rootName, $chunkSize)
    {
        $client = Mage::helper('recommender/pest');
        
        try 
        {
            $uri = $this->_appendAuthToUri("{$rootName}/");
            $lastEntityId = (int)$client->get($uri);
            
            $where = "WHERE $primaryKey > $lastEntityId";
            $this->postRecordset($columns, $table, '', $where, $primaryKey, $rootName, $chunkSize);
        }
        catch(Exception $e)
        {
            //throw new Exception($e->getMessage(), $e->getCode(), $e);
            $this->reportException($e);
        }
        
    }
    
    public function getUpdateXml($rootName)
    {
        $client = Mage::helper('recommender/pest');
        
        try 
        {
            $uri = $this->_appendAuthToUri("{$rootName}/");
            $xml = $client->get($uri);
            //$xml = $client->get("$uri&start_debug=1&debug_host=127.0.0.1&debug_port=10137&original_url=http%3A%2F%2Flocalhost%2Frecommender%2Fpublic%2Forder&use_remote=1");
            return $xml;
        }
        catch(Exception $e)
        {
            $this->reportException($e);
        }
    }
    
    protected function _getRecommenderVersion()
    {
		$modules = (array)Mage::getConfig()->getNode('modules')->children();
		$module = $modules['CommerceStack_Recommender'];
		return (string)$module->version;
    }
    
    public function setTotalTasks($totalTasks)
    {
        $this->_totalTasks = $totalTasks;
    }
    
    public function setCurrentTask($curTask)
    {
        $this->_currentTask = $curTask;
    }
    
    public function setClientStatus($clientStatus)
    {
        $client = Mage::helper('recommender/pest');
        
        try 
        {
            $uri = $this->_appendAuthToUri("status/");
            $client->post($uri, $clientStatus);
            //$client->post("$uri&start_debug=1&debug_host=127.0.0.1&debug_port=10137&original_url=http%3A%2F%2Flocalhost%2Frecommender%2Fpublic%2Fordercollection&use_remote=1", $clientStatus);
        }
        catch(Exception $e)
        {
            $this->reportException($e);
        }
    }
    
    public function reportException($e)
    {
        $client = Mage::helper('recommender/pest');
        $client->curl_opts[CURLOPT_TIMEOUT] = 3;
        $errorReport = $e->getMessage() . "\n" . $e->getTraceAsString();
        
        try 
        {
            $uri = $this->_appendAuthToUri("exception/");
            $client->post($uri, $errorReport);
        }
        catch(Exception $e)
        {
            //throw new Exception($e->getMessage(), $e->getCode(), $e);
        }
    }
    
    public function getApiKeyAsJson()
    {
        $retJson = array();
        $retJson['apiUser'] = Mage::getStoreConfig('recommender/api_user');
        $retJson['apiSecret'] = Mage::getStoreConfig('recommender/api_secret');
        
        return json_encode($retJson);
    }
    
    public function getTableNameSafe($modelEntity)
    {
        try 
        {
            $tableName = Mage::getSingleton('core/resource')->getTableName($modelEntity);
        }
        catch(Exception $e)
        {
            $this->reportException($e);
        }
        
        return $tableName;
    }
    
}  