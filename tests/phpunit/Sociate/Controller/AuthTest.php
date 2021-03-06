<?php
namespace phpunit\Sociate\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class AuthTest extends \PHPUnit_Framework_TestCase
{
    /**
     * 
     * @var \Slim\Conatiner
     */
    public $container;
	/**
	 * 
	 * @var \Psr\Http\Message\ServerRequestInterface
	 */
	public $request;
	
	/**
	 * @var \Psr\Http\Message\ResponseInterface
	 */
	public $response;
	
	public function setUp()
	{
		parent::setUp();
		
		$this->container = new \Slim\Container();
		$this->request = $this->getMockBuilder('\Slim\Http\Request')
			->disableOriginalConstructor()
            ->getMock();
		
		$this->response = $this->getMockBuilder('\Slim\Http\Response')
			->disableOriginalConstructor()
            ->getMock();
	}
	
	/**
	 * @test
	 * @covers \Sociate\Controller\Auth::__construct
	 */
	public function testConstructor()
	{
	    $securityService = $this->getMockBuilder('\Sociate\Security\SecurityService')
	    ->disableOriginalConstructor()
	    ->getMock();
	    
	    $userService = $this->getMockBuilder('\Sociate\Service\UserService')
	       ->disableOriginalConstructor()
	       ->getMock();
	    
	    $controller = new \Sociate\Controller\Auth($userService,$securityService);
	    $this->assertInstanceOf('\Sociate\Controller\Auth',$controller);
	}
	
	/**
	 * @test
	 * @covers \Sociate\Controller\Auth::post
	 */
	public function testFailedPost()
	{
	    $username = 'username';
	    $password = 'password';
	    $params = [ 'username' => $username, 'password' => $password ];
	    $user = null;
	    
	    $this->request->expects($this->once())
	       ->method('getParsedBody')
	       ->willReturn($params);
	    
	    $securityService = $this->getMockBuilder('\Sociate\Security\SecurityService')
	       ->disableOriginalConstructor()
	       ->getMock();
	        
	       
	    $userService = $this->getMockBuilder('\Sociate\Service\UserService')
	       ->disableOriginalConstructor()
	       ->getMock();
	       
	    $userService->expects($this->once())
	       ->method('authenticate')
	       ->with($username,$password)
	       ->willReturn($user);
	          
	    $controller = new \Sociate\Controller\Auth($userService,$securityService);
	    
 		$res = $controller->post($this->request,$this->response,[]);
	}
}