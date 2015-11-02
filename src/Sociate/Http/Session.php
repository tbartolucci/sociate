<?php
namespace Sociate\Http;

class Session
{
    
    /**
     *
     * @var \MongoDB
     */
    protected $db;
    
    /**
     * 
     * @var \MongoCollection
     */
    protected $sessions;
    
    /**
     * 
     * @var array
     */
    protected $data = [];
    
    /**
     * 
     * @param \MongoDB $db
     */
    public function __construct(\MongoDB $db)
    {
        $this->db = $db;
        $this->sessions = $this->db->sessions;
    }
    
    /**
     * Load session data by access token
     * 
     * @param string $accessToken
     * @throws Exception
     */
    public function load($accessToken)
    {
        $session = $this->sessions->findOne(['token' => $accessToken]);
        if( !$session){
           return false;
        }
        $this->data = $session;
        return true;
    }
    /**
     * Write the session back to the db
     * 
     * @return boolean
     */
    public function write()
    {
        return $this->sessions->save(['token' => $this->data['token']],$this->data);
    }
    
    /**
     * Retrieve the data identfied by key
     * 
     * @param mixed $key
     * @return NULL|mixed
     */
    public function __get($key)
    {
       if( !$this->data ){
           return null;
       }
       if( !isset($this->data[$key])){
           return null;
       }
       
       return $this->data[$key];
    }
    
    /**
     * Set $value to $key
     * 
     * @param mixed $key
     * @param mixed $value
     * @return NULL
     */
    public function __set($key,$value)
    {
        $this->data[$key] = $value;
    }
}
