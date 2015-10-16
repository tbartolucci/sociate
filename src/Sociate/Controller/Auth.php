<?php
namespace Sociate\Controller;

class Auth extends \Sociate\ContainerAware
{
	public function post(\Slim\Http\Request $request,\Slim\Http\Response $response,array $args)
	{
	    $params = $request->getParsedBody();
	
	    $userService = $this->container['userService'];
	    
	    $user = $userService->authenticate($params['username'],$params['password']);
	    
		if( !$user ){
		  return $response->write("Failed");	
		}
		
	   //TODO persist session and generate auth token	
	}
}