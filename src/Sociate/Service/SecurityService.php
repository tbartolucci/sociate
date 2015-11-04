<?php
namespace Sociate\Service;

class SecurityService
{
    const TOKEN_NAME = 'ACCESSTOKEN';
    
    /**
     * 
     * @var \Sociate\Http\Session
     */
    protected $session;
    
    /**
     * 
     * @param \Slim\Container $container
     */
    public function __construct(\Sociate\Http\Session $session)
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
}