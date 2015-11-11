<?php
namespace Sociate\Service;

class UserService
{
    const UNKOWN = 0;
    const CONNECTED = 1;
    const DETAILS = 2;
    
    /**
     * 
     * @var \MongoDB\Collection
     */
    protected $collection;
    
    public function __construct(\MongoDB\Collection $collection)
    {
        $this->collection = $collection;
    }
    
    /**
     * 
     * @param string $username
     * @param string $password
     * @return object
     */
    public function authenticate($username,$password)
    {
        $passwordHash = $this->toHash($password);
        
        $user = $this->collection->findOne(['username' => $username, 'password' => $passwordHash]);
         
        return $user;
    }
    
    /**
     * 
     * @param string $password
     * @return string
     */
    public function toHash($password)
    {
        return $password;
    }
    
    /**
     * Based on the detail level reduce the amount of data we should return
     * 
     * @param array $user
     * @param int $details
     * @return array
     */
    public function filterData($user,$details=self::UNKOWN)
    {
        return $user;
    }
    
    /**
     * Retrieve a user with details defined by the const
     * 
     * @param int $id
     * @param int $details
     */
    public function get($id,$details=self::UNKOWN)
    {     
        $user = $this->collection->findOne(['id' => $id]);
        
        return $this->filterData($user,$details);
    }
    
    public function create($data)
    {
        if( !isset($data['email'])){
            //No email provided
        }
        
        if( !filter_var($data['email'],FILTER_VALIDATE_EMAIL) ){
            //Invalid email
        }
        
        //check for duplicate email
        $user = $this->collection->findOne(['email' => $data['email']]);
        if( $user ){
            //Duplicate email address
        }
        
        
        
        return $id;
    }
}