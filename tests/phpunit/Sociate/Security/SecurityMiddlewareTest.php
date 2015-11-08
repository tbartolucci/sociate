<?php
namespace phpunit\Sociate\Security;

class SecurityMiddlewareTest extends \PHPUnit_Framework_TestCase
{
    protected $security;
    
    public function setUp()
    {
        parent::setUp();
        $this->security = $this->getMockBuilder('\Sociate\Security\SecurityService')
        ->disableOriginalConstructor()
        ->getMock();
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
        
    }
    
    /**
     * @test
     * @covers \Sociate\Security\SecurityMiddleware::__invoke
     */
    public function testInvokeException()
    {
        
    }
    
}