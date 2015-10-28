<?php
namespace Sociate\Controller;

class User extends \Sociate\ContainerAware
{
    /**
     * 
     * @var \Sociate\Service\UserService
     */
    protected $service;
    
    public function __construct(\Slim\Container $c)
    {
        parent::__construct($c);
        $this->service = $this->container['userService'];
    }
    
    /**
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     */
    public function get(\Slim\Http\Request $request,\Slim\Http\Response $response,array $args)
    {
        
    }
    
    /**
     *
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     */
    public function post(\Slim\Http\Request $request,\Slim\Http\Response $response,array $args)
    {
        
    }
    
    /**
     *
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     */
    public function put(\Slim\Http\Request $request,\Slim\Http\Response $response,array $args)
    {
        
    }
    
    /**
     *
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     */
    public function delete(\Slim\Http\Request $request,\Slim\Http\Response $response,array $args)
    {
        
    }
}