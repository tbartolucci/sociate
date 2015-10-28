<?php
namespace Sociate;

class ContainerAware
{
    /**
     *
     * @var \Slim\Container $container
     */
    protected $container;
    
    /**
     * 
     * @param \Slim\Container $container
     */
    public function __construct(\Slim\Container $container)
    {
        $this->container = $container;
    }
    
    /**
     * 
     * @return \Slim\Container
     */
    public function getContainer()
    {
        return $this->container;
    }
    
    /**
     * 
     * @param \Slim\Container $container
     */
    public function setContainer(\Slim\Container $container)
    {
        $this->container = $container;
    }
}