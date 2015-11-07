<?php
namespace Sociate\Security;

class SecurityService
{
    const TOKEN_NAME = 'ACCESSTOKEN';
    
    /**
     * 
     * @var \Sociate\Session
     */
    protected $session;
    
    /**
     * 
     * @param \Slim\Container $container
     */
    public function __construct(\Sociate\Session $session)
    {
        $this->session = $session;
    }
    
    /**
     * 
     * @param array $user
     * @return string
     */
    public function createSession($user)
    {
        $token = $this->generateAccessToken();
        $this->session->token = $token;
        $this->session->user = $user;
        $this->session->write();
        return $token;
    }
    
    /**
     * 
     * @return string
     */
    public function generateAccessToken()
    {
        return uniqid('EVOLVD',true);
    }
    
    /**
     * Load a session from the database by token
     * 
     * @param string $token
     */
    public function validateAccessToken($token)
    {
        return $this->session->load($token);
    }
}