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
    
    public function __construct(\Slim\Container $c)
    {
        parent::__construct($c);
        $this->service = $this->container['userService'];
    }
    
	public function post(\Slim\Http\Request $request,\Slim\Http\Response $response,array $args)
	{
	    $params = $request->getParsedBody();
	
	    $user = $this->service->authenticate($params['username'],$params['password']);
	    
		if( !$user ){
		  return $response->write("Failed");	
		}
		
		var_dump($user);
	   //TODO persist session and generate auth token	
	}
}