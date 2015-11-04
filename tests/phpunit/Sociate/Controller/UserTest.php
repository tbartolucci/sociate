<?php
namespace phpunit\Sociate\Controller;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * 
     * @var \Sociate\Service\UserService
     */
    protected $userService;
    
    public function setUp()
    {
        $this->userService = $this->getMockBuilder('\Sociate\Service\UserService')
            ->disableOriginalConstructor()
            ->getMock();
    }
    
    /**
     * @test
     * @covers \Sociate\Controller\User::__construct
     */
    public function testConstructor()
    {
        $controller = new \Sociate\Controller\User($this->userService);
        $this->assertInstanceOf('\Sociate\Controller\User',$controller);
    }
    
    /**
     * @test
     * @covers \Sociate\Controller\User::get
     */
    public function testGet()
    {
        
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