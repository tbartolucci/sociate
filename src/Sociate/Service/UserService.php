<?php
namespace Sociate\Service;

class UserService
{
    const UNKOWN = 0;
    const CONNECTED = 1;
    const DETAILS = 2;
    
    /**
     * 
     * @var \MongoDB\Database
     */
    protected $db;
    
    public function __construct(\MongoDB\Database $db)
    {
        $this->db = $db;
    }
    
    /**
     * 
     * @param string $username
     * @param string $password
     * @return object
     */
    public function authenticate($username,$password)
    {
        $users = $this->db->selectCollection('users');

        $passwordHash = $this->toHash($password);
        
        $user = $users->findOne(['username' => $username, 'password' => $passwordHash]);
         
        return $user;
    }
    
    /**
     * 
     * @param string $password
     * @return string
     */
    public function toHash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
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
        $users = $this->db->selectCollection('users');
        
        $user = $users->findOne(['id' => $id]);
        
        return $this->filterData($user,$details);
    }
    
    public function create($data)
    {
        
    }
}