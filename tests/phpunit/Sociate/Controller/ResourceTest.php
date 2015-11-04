<?php
namespace phpunit\Sociate\Controller;

class ResourceTest extends \PHPUnit_Framework_TestCase
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
     * @covers \Sociate\Controller\Resource::__construct
     */
    public function testConstructor()
    {
        $controller = new \Sociate\Controller\Resource($this->userService);
        $this->assertInstanceOf('\Sociate\Controller\Resource',$controller);
    }

    /**
     * @test
     * @covers \Sociate\Controller\Resource::get
     */
    public function testGet()
    {

    }

    /**
     * @test
     * @covers \Sociate\Controller\Resource::post
     */
    public function testPost()
    {

    }

    /**
     * @test
     * @covers \Sociate\Controller\Resource::put
     */
    public function testPut()
    {

    }

    /**
     * @test
     * @covers \Sociate\Controller\Resource::delete
     */
    public function testDelete()
    {

    }
}