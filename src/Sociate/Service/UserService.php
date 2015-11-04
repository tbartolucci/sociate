<?php
namespace Sociate\Service;

class UserService
{
    /**
     * 
     * @var \MongoDB
     */
    protected $db;
    
    public function __construct(\MongoDB $db)
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
        $users = $this->db->users;

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
        return $password;
    }
}