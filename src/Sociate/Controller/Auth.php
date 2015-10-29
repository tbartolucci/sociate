<?php
namespace Sociate\Controller;

class Auth
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
	public function post(\Slim\Http\Request $request,\Slim\Http\Response $response,array $args)
	{
	    $params = $request->getParsedBody();
	
	    $user = $this->service->authenticate($params['username'],$params['password']);
	    
		if( !$user ){
		  return $response->write("Failed");	
		}
        
		
	}
}