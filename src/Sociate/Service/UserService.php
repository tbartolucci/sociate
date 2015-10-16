<?php
namespace Sociate\Service;

class UserService extends \Sociate\ContainerAware
{
    /**
     * 
     * @param string $username
     * @param string $password
     * @return object
     */
    public function authenticate($username,$password)
    {
        $db = $this->container['db'];
        
        $users = $db->users;

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