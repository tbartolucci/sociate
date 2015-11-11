<?php
namespace phpunit\Sociate\Security;


class SecurityMiddlewareTest extends \PHPUnit_Framework_TestCase
{
    protected $security;
    protected $request;
    protected $response;
    protected $next;
    
    public function setUp()
    {
        parent::setUp();
        $this->security = $this->getMockBuilder('\Sociate\Security\SecurityService')
        ->disableOriginalConstructor()
        ->getMock();
        
        $this->request = $this->getMockBuilder('\Slim\Http\Request')
			->disableOriginalConstructor()
            ->getMock();
		
		$this->response = $this->getMockBuilder('\Slim\Http\Response')
			->disableOriginalConstructor()
            ->getMock();
		
        $this->next = function($request,$response){
          return $response;  
        };
    }
    
    
    /**
     * @test
     * @covers \Sociate\Security\SecurityMiddleware::__construct
     */
    public function testConstructor()
    {
        $middleware = new \Sociate\Security\SecurityMiddleware($this->security);
        $this->assertInstanceOf('\Sociate\Security\SecurityMiddleware', $middleware);
    }
 
    /**
     * @test
     * @covers \Sociate\Security\SecurityMiddleware::__invoke
     */
    public function testInvoke()
    {
        $token = 'sometoken';
        $this->request->expects($this->once())
            ->method('getHeader')
            ->with(\Sociate\Security\SecurityService::TOKEN_NAME)
            ->willReturn($token);
        
        $this->security->expects($this->once())
            ->method('validateAccessToken')
            ->with($token)
            ->willReturn(true);
        
        $this->response->expects($this->once())
            ->method('withHeader')
            ->with(\Sociate\Security\SecurityService::TOKEN_NAME,$token)
            ->willReturnSelf();
        
        $middleware = new \Sociate\Security\SecurityMiddleware($this->security);
        $response = $middleware($this->request,$this->response,$this->next);
        
        $this->assertSame($this->response,$response);
    }
    
    /**
     * @test
     * @covers \Sociate\Security\SecurityMiddleware::__invoke
     */
    public function testInvokeException()
    {
        $token = 'sometoken';
        $this->request->expects($this->once())
            ->method('getHeader')
            ->with(\Sociate\Security\SecurityService::TOKEN_NAME)
            ->willReturn($token);
        
        $this->security->expects($this->once())
            ->method('validateAccessToken')
            ->with($token)
            ->willReturn(false);
        
        $this->setExpectedException('\Sociate\Security\Exception','Invalid authorization token',403);
        $middleware = new \Sociate\Security\SecurityMiddleware($this->security);
        $response = $middleware($this->request,$this->response,$this->next);
         
    }
    
}