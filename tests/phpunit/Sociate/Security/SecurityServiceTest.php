<?php
namespace phpunit\Sociate\Security;

class SecurityServiceTest extends \PHPUnit_Framework_TestCase
{
    protected $session;
    
    public function setUp()
    {
        parent::setUp();  
        $this->session = $this->getMockBuilder('\Sociate\Session')
            ->disableOriginalConstructor()
            ->getMock();
    }
    
    
    /**
     * @test
     * @covers \Sociate\Security\SecurityService::__construct
     */
    public function testConstructor()
    {
        $security = new \Sociate\Security\SecurityService($this->session);
        $this->assertInstanceOf('\Sociate\Security\SecurityService', $security);
    }
    
    /**
     * @test
     * @covers \Sociate\Security\SecurityService::createSession
     */
    public function testCreateSession()
    {
        $user = [ 'username' => 'user' ];
        
        $this->session->expects($this->at(1))
            ->method('__set')
            ->with('user',$user);
     
        $this->session->expects($this->at(2))
             ->method('write');
            
        $security = new \Sociate\Security\SecurityService($this->session);
        
        $token = $security->createSession($user);

        $this->assertStringStartsWith('EVOLVD', $token);
        $this->assertEquals((23+6),strlen($token));
    }
    
    /**
     * @test
     * @covers \Sociate\Security\SecurityService::generateAccessToken
     */
    public function testGenerateAccessToken()
    {
        $security = new \Sociate\Security\SecurityService($this->session);
        $token = $security->generateAccessToken();
        $this->assertStringStartsWith('EVOLVD', $token);
        $this->assertEquals((23+6),strlen($token));
    }
    
    /**
     * @test
     * @covers \Sociate\Security\SecurityService::validateAccessToken
     */
    public function testValidateAccessToken()
    {
        $security = new \Sociate\Security\SecurityService($this->session);
        $token = $security->generateAccessToken();
        
        $this->session->expects($this->once())
            ->method('load')
            ->with($token)
            ->willReturn(true);
        
        $result = $security->validateAccessToken($token);   
        $this->assertTrue($result);
    }
}