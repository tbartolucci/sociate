<?php
namespace Sociate\Service;

use Sociate\ContainerAware;
class SecurityService extends \Sociate\ContainerAware
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
    public function __construct(\Slim\Container $container)
    {
        parent::__construct($container);
        $this->session = $this->container['session'];
    }
    
    
}