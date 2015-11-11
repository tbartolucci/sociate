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
            ->with([ 'message' => $message],$code)
            ->willReturnSelf();
            
        $exception = new \Exception($message,$code);
        
        $response = $handler($request,$response,$exception);
        $this->assertInstanceOf('\Slim\Http\Response',$response);
    }
    
    /**
     * @test
     * @covers \Sociate\ContainerProvider::db
     */
    public function testDb()
    {
       
    }
    
    /**
     * @test
     * @covers \Sociate\ContainerProvider::collection
     */
    public function testCollection()
    {
        $mongoCollection = $this->getMock('\MongoDB\Collection',[],[],'',false);
        
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
        $this->assertInstanceOf('\Sociate\Collection\Collection',$collection);
    }
    
    
     /**
      * This test is strange. Because of the calling of the closure
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
        $this->container['collection'] = function(){
          return function($name) { return $name;};
        };
          
        $collectionName = $this->provider->userCollection($this->container);
        $this->assertEquals('user',$collectionName);
    }
    
    /**
     * This test is strange. Because of the calling of the closure
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
        $this->container['collection'] = function(){
            return function($name) {
                return $this->getMock('\Sociate\Collection\Collection',[],[],'',false);
            };
        };
    
        $session = $this->provider->session($this->container);
        $this->assertInstanceOf('\Sociate\Session',$session);
    }
}