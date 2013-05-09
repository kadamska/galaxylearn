<?php

define("API_KEY", "Jw_AkCQGOcVx4PyG8ZhSWf38TsxIaH6C");
define("OID", "$oid");

/**
* Basic wrapper for MongoLab data access. (@sammcafee, May '13)
* Usage:
* Set your API key above.
* $SomeService = new DataService("someObjectType");
* $data = $SomeService->service_get();
*/
class DataService
{
	protected $URL;
	protected $key;

	function __construct($collection = "stories")
	{
		$this->URL = "https://api.mongolab.com/api/1/databases/";
		$this->key = "?apiKey=" . API_KEY;
		$this->database = "galaxydb/collections/";
		$this->collection = $collection ."/";
	}

	function service_get($query = NULL) {

		$query = "&q=" . json_encode($query);

		$path = $this->URL . $this->database . $this->collection . $this->key  . $query;
		error_log("MongoLab call" . $path);

		$ch = curl_init($path);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		    'Content-Type: application/json')                                                                     
		);                                                                                                                   
		 
		$result = curl_exec($ch);
		curl_close($ch);
	    return $result;
		
	}

	function service_get_one($oid) {

		$path = $this->URL . $this->database . $this->collection . $oid . $this->key;

		$ch = curl_init($path);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		    'Content-Type: application/json')                                                                     
		);                                                                                                                   
		 
		$result = curl_exec($ch);
		curl_close($ch);
	    return $result;
		
	}

	function service_post($data) {
		$data = json_encode($data);

		$path = $this->URL . $this->database . $this->collection . $this->key;
		error_log($path);
		$ch = curl_init($path);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		    'Content-Type: application/json',                                                                                
		    'Content-Length: ' . strlen($data))                                                                       
		);                                                                                                                   
		 
		$result = json_decode(curl_exec($ch), true);
		curl_close($ch);
		return $result['_id']['$oid'];

	}

	function service_update($oid, $changes) {
		if (empty($changes)) {
			return;
		}

		$data_string = json_encode($changes);
		
		$path = $this->URL . $this->database . $this->collection . $oid . $this->key;

		$ch = curl_init($path);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		    'Content-Type: application/json',                                                                                
		    'Content-Length: ' . strlen($data_string))                                                                       
		);                                                                                                                   
		 
		$result = json_decode(curl_exec($ch));
		curl_close($ch);
	}

	function service_delete($oid) {

		$path = $this->URL . $this->database . $this->collection . $oid . $this->key;

		$ch = curl_init($path);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");                                                                     
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		    'Content-Type: application/json')                                                                     
		);                                                                                                                   
		 
		$result = curl_exec($ch);
		curl_close($ch);
	    return $result;
		
	}
}

?>