<?php
namespace Sociate\Controller;

use \Sociate\Security\SecurityService;

class Auth
{
    /**
     * 
     * @var \Sociate\Service\UserService
     */
    protected $userService;
    
    /**
     * 
     * @var \Sociate\Security\SecurityService
     */
    protected $securityService;
    
    /**
     * 
     * @param \Sociate\Service\UserService $userService
     * @param \Sociate\Service\SecurityService $securityService
     */
    public function __construct(\Sociate\Service\UserService $userService, \Sociate\Security\SecurityService $securityService)
    {
        $this->userService = $userService;
        $this->securityService = $securityService;
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
	
	    $user = $this->userService->authenticate($params['username'],$params['password']);
	     
		if( !$user ){
		  return $response->write("Failed");	
		}
        
		$accessToken = $this->securityService->createSession($user);
		
		return $response
		  ->withHeader(SecurityService::TOKEN_NAME, $accessToken)
		  ->withJson(['status' => 'success']);
	}
}