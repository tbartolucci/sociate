<?php
namespace Sociate\Controller;

use Sociate\ContainerAware;
class Auth extends \Sociate\ContainerAware
{
    /**
     * 
     * @var \Sociate\Service\UserService
     */
    protected $service;
    /**
     * 
     * @param \Slim\Container $c
     */
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
	public function post(\Slim\Http\Request $request,\Slim\Http\Response $response,array $args)
	{
	    $params = $request->getParsedBody();
	
	    $user = $this->service->authenticate($params['username'],$params['password']);
	    
		if( !$user ){
		  return $response->write("Failed");	
		}
        
		
	}
}