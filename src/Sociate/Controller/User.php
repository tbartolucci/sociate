<?php
namespace Sociate\Controller;

class User
{
    /**
     * 
     * @var \Sociate\Service\UserService
     */
    protected $service;
    
    /**
     * 
     * @param \Sociate\Service\UserService $service
     */
    public function __construct(\Sociate\Service\UserService $service)
    {
        $this->service = $service;
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