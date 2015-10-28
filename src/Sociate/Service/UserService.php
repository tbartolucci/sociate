<?php
namespace Sociate\Service;

use Sociate\ContainerAware;
class UserService extends \Sociate\ContainerAware
{
    /**
     * 
     * @var \MongoDB
     */
    protected $db;
    
    public function __construct(\Slim\Container $c)
    {
        parent::__construct($c);
        $this->db = $this->container['db'];
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