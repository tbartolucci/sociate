<?php
namespace Sociate\Service;

class SecurityService
{
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
    
    
}