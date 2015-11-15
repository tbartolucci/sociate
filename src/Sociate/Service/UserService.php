<?php
namespace Sociate\Service;

class UserService
{

    const UNKOWN = 0;

    const CONNECTED = 1;

    const DETAILS = 2;

    /**
     *
     * @var \Sociate\Collection\Collection
     */
    protected $collection;

    public function __construct(\Sociate\Collection\Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     *
     * @param string $username            
     * @param string $password            
     * @return object|bool
     */
    public function authenticate($username, $password)
    {
        $user = $this->collection->findOne([
            'username' => $username
        ]);
        
        if (password_verify($password, $user->password)) {
            return $user;
        } else {
            return false;
        }
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
    public function filterData($user, $details = self::UNKOWN)
    {
        return $user;
    }

    /**
     * Retrieve a user with details defined by the const
     *
     * @param int $id            
     * @param int $details            
     */
    public function get($id, $details = self::UNKOWN)
    {
        $user = $this->collection->findOne([
            'id' => $id
        ]);
        
        return $this->filterData($user, $details);
    }

    public function create($data)
    {
        if (! isset($data['email'])) {
            // No email provided
        }
        
        if (! filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            // Invalid email
        }
        
        // check for duplicate email
        $user = $this->collection->findOne([
            'email' => $data['email']
        ]);
        if ($user) {
            // Duplicate email address
        }
        
        return $id;
    }
}