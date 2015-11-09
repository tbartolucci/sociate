<?php
namespace phpunit\Sociate\Controller;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * 
     * @var \Sociate\Service\UserService
     */
    protected $userService;
    protected $session;
    protected $request;
    protected $response;
    
    public function setUp()
    {
        $this->userService = $this->getMockBuilder('\Sociate\Service\UserService')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->session = $this->getMockBuilder('\Sociate\Session')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->request = $this->getMockBuilder('\Slim\Http\Request')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->response = $this->getMockBuilder('\Slim\Http\Response')
            ->disableOriginalConstructor()
            ->getMock();
    }
    
    /**
     * @test
     * @covers \Sociate\Controller\User::__construct
     */
    public function testConstructor()
    {
        $controller = new \Sociate\Controller\User($this->userService, $this->session);
        $this->assertInstanceOf('\Sociate\Controller\User',$controller);
    }
    
    /**
     * @test
     * @covers \Sociate\Controller\User::get
     */
    public function testGetUknown()
    {       
        $id = 100;
        $user = [ 'id' => 200 , 'cards' => [] ];
        $user2 = [ 'id' => $id , 'cards' => [ 'userId' => 300 ] ];
        
        $args = [ 'id' => $id ];
        
        $this->session->expects($this->once())
            ->method('__get')
            ->with('user')
            ->willReturn($user);
        
        $this->userService->expects($this->once())
            ->method('get')
            ->with($id,\Sociate\Service\UserService::UNKOWN)
            ->willReturn($user);
        
        $this->response->expects($this->once())
            ->method('withJson')
            ->with($user)
            ->willReturnSelf();
        
        $controller = new \Sociate\Controller\User($this->userService, $this->session);
        
        $response = $controller->get($this->request,$this->response,$args);
        $this->assertSame($this->response,$response);
    }
    
    /**
     * @test
     * @covers \Sociate\Controller\User::get
     */
    public function testGetSelf()
    {
        $id = 200;
        $user = [ 'id' => $id , 'cards' => [] ];
        $user2 = [ 'id' => $id , 'cards' => [ 'userId' => 300 ] ];
    
        $args = [ 'id' => $id ];
    
        $this->session->expects($this->once())
        ->method('__get')
        ->with('user')
        ->willReturn($user);
    
        $this->userService->expects($this->once())
        ->method('get')
        ->with($id,\Sociate\Service\UserService::DETAILS)
        ->willReturn($user);
    
        $this->response->expects($this->once())
        ->method('withJson')
        ->with($user)
        ->willReturnSelf();
    
        $controller = new \Sociate\Controller\User($this->userService, $this->session);
    
        $response = $controller->get($this->request,$this->response,$args);
        $this->assertSame($this->response,$response);
    }
    
    /**
     * @test
     * @covers \Sociate\Controller\User::get
     */
    public function testGetConnected()
    {
        $id = 200;
        $user = [ 'id' => 100 , 'cards' => [ ['id' => 400 ], ['id' => $id] ] ];
        $user2 = [ 'id' => $id , 'cards' => [] ];
    
        $args = [ 'id' => $id ];
    
        $this->session->expects($this->once())
        ->method('__get')
        ->with('user')
        ->willReturn($user);
    
        $this->userService->expects($this->once())
        ->method('get')
        ->with($id,\Sociate\Service\UserService::CONNECTED)
        ->willReturn($user);
    
        $this->response->expects($this->once())
        ->method('withJson')
        ->with($user)
        ->willReturnSelf();
    
        $controller = new \Sociate\Controller\User($this->userService, $this->session);
    
        $response = $controller->get($this->request,$this->response,$args);
        $this->assertSame($this->response,$response);
    }
    
    /**
     * @test
     * @covers \Sociate\Controller\User::post
     */
    public function testPost()
    {
    
    }
    
    /**
     * @test
     * @covers \Sociate\Controller\User::put
     */
    public function testPut()
    {
    
    }
    
    /**
     * @test
     * @covers \Sociate\Controller\User::delete
     */
    public function testDelete()
    {
    
    }    
}