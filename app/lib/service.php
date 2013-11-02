<?php
/**
* Basic wrapper for MongoLab data access. (@sammcafee, May '13)
* Usage:
*     Set your API key above.
*     $SomeService = new DataService("someObjectType");
*     $data = $SomeService->service_get();
*/
class DataService
{
    /**
     * Service API key
     * @var string
     */
    const API_KEY = "Jw_AkCQGOcVx4PyG8ZhSWf38TsxIaH6C";
    
    protected $URL;
    protected $key;
    protected $database;
    protected $collection;
    
    /**
     * Constructor
     * @param string $collection collection
     */
    function __construct($collection = "stories")
    {
        $this->URL = "https://api.mongolab.com/api/1/databases/";
        $this->key = "?apiKey=" . self::API_KEY;
        $this->database = "galaxydb/collections/";
        $this->collection = $collection ."/";
    }

    /**
     * Get collection by query
     * @param string $query query
     * @return mixed
     */
    function service_get($query = null) 
    {
        $query = "&q=" . json_encode($query);
        $path = $this->URL . $this->database . $this->collection . $this->key  . $query;
        $path .= "&s={'id':1}";    
        
        error_log("MongoLab call - get all - " . $path);
        
        $ch = curl_init($path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        /*
         * TODO The following defeats the purpose of SSL
         * Need to get certificates for new curl: http://curl.haxx.se/docs/sslcerts.html
         */
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * Get one object
     * @param string $oid object id
     * @return mixed
     */
    function service_get_one($oid) 
    {
        $path = $this->URL . $this->database . $this->collection . $oid . $this->key;
        error_log("MongoLab call - get one - " . $path);
        
        $ch = curl_init($path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        /*
         * TODO The following defeats the purpose of SSL
        * Need to get certificates for new curl: http://curl.haxx.se/docs/sslcerts.html
        */
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
        
    }

    /**
     * Post
     * @param mixed $data data
     */
    function service_post($data) 
    {
        $data = json_encode($data);
        $path = $this->URL . $this->database . $this->collection . $this->key;
        error_log("MongoLab call - insert - " . $path);
        
        $ch = curl_init($path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
        );
        /*
         * TODO The following defeats the purpose of SSL
        * Need to get certificates for new curl: http://curl.haxx.se/docs/sslcerts.html
        */
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $result['_id']['$oid'];
    }

    /**
     * Update
     * @param string $oid object id
     * @param mixed $changes changes
     * @return boolean true if updated, false otherwise
     */
    function service_update($oid, $changes) 
    {
        if (empty($changes)) {
            return false;
        }
        
        $data_string = json_encode($changes);
        $path = $this->URL . $this->database . $this->collection . $oid . $this->key;
        error_log("MongoLab call - update - " . $path);
        
        $ch = curl_init($path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        /*
         * TODO The following defeats the purpose of SSL
        * Need to get certificates for new curl: http://curl.haxx.se/docs/sslcerts.html
        */
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);
        
        return (boolean) (is_array($result) && array_key_exists('authorized', $result) && $result['authorized'] == 1);
    }

    /**
     * Delete
     * @param string $oid object id
     * @return mixed
     */
    function service_delete($oid) 
    {
        $path = $this->URL . $this->database . $this->collection . $oid . $this->key;
        error_log("MongoLab call - delete - " . $path);
        
        $ch = curl_init($path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        /*
         * TODO The following defeats the purpose of SSL
        * Need to get certificates for new curl: http://curl.haxx.se/docs/sslcerts.html
        */
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    
}

