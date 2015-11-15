<?php
namespace phpunit\Sociate;

class ContainerProviderTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \Slim\Container
     */
    protected $container;

    /**
     *
     * @var \Sociate\ContainerProvider
     */
    protected $provider;

    public function setUp()
    {
        parent::setUp();
        $this->provider = new \Sociate\ContainerProvider();
        $this->container = new \Slim\Container();
    }

    /**
     * @test
     * @covers \Sociate\ContainerProvider::errorHandler
     */
    public function testErrorHandler()
    {
        $message = 'error message';
        $code = 400;
        
        $handler = $this->provider->errorHandler($this->container);
        $this->assertTrue(is_callable($handler));
        
        $request = $this->getMockBuilder('\Slim\Http\Request')
            ->disableOriginalConstructor()
            ->getMock();
        $response = $this->getMockBuilder('\Slim\Http\Response')
            ->disableOriginalConstructor()
            ->getMock();
        $response->expects($this->once())
            ->method('withJson')
            ->with([
            'message' => $message
        ], $code)
            ->willReturnSelf();
        
        $exception = new \Exception($message, $code);
        
        $response = $handler($request, $response, $exception);
        $this->assertInstanceOf('\Slim\Http\Response', $response);
    }

    /**
     * @test
     * @covers \Sociate\ContainerProvider::db
     */
    public function testDb()
    {}

    /**
     * @test
     * @covers \Sociate\ContainerProvider::collection
     */
    public function testCollection()
    {
        $mongoCollection = $this->getMock('\MongoDB\Collection', [], [], '', false);
        
        $this->container['db'] = $this->getMockBuilder('\MongoDB\Database')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->container['db']->expects($this->once())
            ->method('selectCollection')
            ->with('users')
            ->willReturn($mongoCollection);
        
        $func = $this->provider->collection($this->container);
        $this->assertTrue(is_callable($func));
        
        $collection = $func('users');
        $this->assertInstanceOf('\Sociate\Collection\Collection', $collection);
    }

    /**
     * This test is strange.
     * Because of the calling of the closure
     * what we're testing here is that the closure returned by
     * $c['collection'] is called with the string 'user'.
     * Since we've already tested the collection generator
     * then our big concern here is that its being called with user.
     *
     * @test
     * @covers \Sociate\ContainerProvider::userCollection
     */
    public function testUserCollection()
    {
        $this->container['collection'] = function () {
            return function ($name) {
                return $name;
            };
        };
        
        $collectionName = $this->provider->userCollection($this->container);
        $this->assertEquals('users', $collectionName);
    }

    /**
     * This test is strange.
     * Because of the calling of the closure
     * what we're testing here is that the closure returned by
     * $c['collection'] is called with the string 'sessions'.
     * Since we've already tested the collection generator
     * then our big concern here is that its being called with sessions.
     *
     * @test
     * @covers \Sociate\ContainerProvider::session
     */
    public function testSession()
    {
        $this->container['collection'] = function () {
            return function ($name) {
                return $this->getMock('\Sociate\Collection\Collection', [], [], '', false);
            };
        };
        
        $session = $this->provider->session($this->container);
        $this->assertInstanceOf('\Sociate\Session', $session);
    }

    /**
     * @test
     * @covers \Sociate\ContainerProvider::security
     */
    public function testSecurity()
    {
        $this->container['session'] = $this->getMock('\Sociate\Session', [], [], '', false);
        $security = $this->provider->security($this->container);
        $this->assertInstanceOf('\Sociate\Security\SecurityService', $security);
    }

    /**
     * @test
     * @covers \Sociate\ContainerProvider::securityMiddleware
     */
    public function testSecurityMiddleware()
    {
        $this->container['security'] = $this->getMock('\Sociate\Security\SecurityService', [], [], '', false);
        $security = $this->provider->securityMiddleware($this->container);
        $this->assertInstanceOf('\Sociate\Security\SecurityMiddleware', $security);
    }

    /**
     * @test
     * @covers \Sociate\ContainerProvider::userService
     */
    public function testUserService()
    {
        $this->container['userCollection'] = $this->getMock('\Sociate\Collection\Collection', [], [], '', false);
        $actual = $this->provider->userService($this->container);
        $this->assertInstanceOf('\Sociate\Service\UserService', $actual);
    }

    /**
     * @test
     * @covers \Sociate\ContainerProvider::authController
     */
    public function testAuthController()
    {
        $this->container['userService'] = $this->getMock('\Sociate\Service\UserService', [], [], '', false);
        $this->container['security'] = $this->getMock('\Sociate\Security\SecurityService', [], [], '', false);
        $actual = $this->provider->authController($this->container);
        $this->assertInstanceOf('\Sociate\Controller\Auth', $actual);
    }

    /**
     * @test
     * @covers \Sociate\ContainerProvider::userController
     */
    public function testUserController()
    {
        $this->container['session'] = $this->getMock('\Sociate\Session', [], [], '', false);
        $this->container['userService'] = $this->getMock('\Sociate\Service\UserService', [], [], '', false);
        $actual = $this->provider->userController($this->container);
        $this->assertInstanceOf('\Sociate\Controller\User', $actual);
    }

    /**
     * @test
     * @covers \Sociate\ContainerProvider::resourceController
     */
    public function testResourceController()
    {
        $this->container['userService'] = $this->getMock('\Sociate\Service\UserService', [], [], '', false);
        $actual = $this->provider->resourceController($this->container);
        $this->assertInstanceOf('\Sociate\Controller\Resource', $actual);
    }
}