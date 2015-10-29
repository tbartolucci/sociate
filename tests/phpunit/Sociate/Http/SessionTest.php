<?php
namespace phpunit\Sociate\Http;

class SessionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * 
     * @var \Slim\Container
     */
    protected $container;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->container = new \Slim\Container();
        $this->container['db'] = $this->getMockBuilder('\MongoDB')
            ->disableOriginalConstructor()
            ->getMock();
        $this->container['db']->sessions = $this->getMockBuilder('\MongoCollection')
            ->disableOriginalConstructor()
            ->getMock();
    }
    
    /**
     * @test
     * @covers \Sociate\Http\Session::__construct
     */
    public function testConstructor()
    {
        $session = new \Sociate\Http\Session($this->container['db']);
        $this->assertInstanceOf('\Sociate\Http\Session',$session);
    }
    
    /**
     * @test
     * @covers \Sociate\Http\Session::load
     */
    public function testLoadFail()
    {
        $accessToken = '123124123adfasd';
        
        $this->container['db']->sessions->expects($this->once())
            ->method('findOne')
            ->with(['token' => $accessToken])
            ->willReturn(null);
    
        $session = new \Sociate\Http\Session($this->container['db']);
        $this->assertFalse($session->load($accessToken));
    }
    
    /**
     * @test
     * @covers \Sociate\Http\Session::load
     */
    public function testLoad()
    {
        $accessToken = '123124123adfasd';
        $session = [ 'token' => $accessToken , 'lastAccessed' => 'timestamp'];
        
        $this->container['db']->sessions->expects($this->once())
            ->method('findOne')
            ->with(['token' => $accessToken])
            ->willReturn($session);
        
        $session = new \Sociate\Http\Session($this->container['db']);
        $this->assertTrue($session->load($accessToken));
    }
    
    /**
     * @test
     * @covers \Sociate\Http\Session::write
     */
    public function testWrite()
    {
        $accessToken = '123124123adfasd';
        $data = [ 'token' => $accessToken , 'lastAccessed' => 'timestamp'];
        
        $this->container['db']->sessions->expects($this->once())
            ->method('update')
            ->with(['token' => $accessToken],$data)
            ->willReturn(true);
        
        $session = new \Sociate\Http\Session($this->container['db']);
        $session->token = $accessToken;
        $session->lastAccessed = 'timestamp';
        $this->assertTrue($session->write());
    }
    
    /**
     * @test
     * @covers \Sociate\Http\Session::__set
     */
    public function testSet()
    {
        $session = new \Sociate\Http\Session($this->container['db']);
        $session->someKey = 'someData';
        $this->assertEquals('someData',$session->someKey);
    }
    
    /**
     * @test
     * @covers \Sociate\Http\Session::__get
     */
    public function testGet()
    {
        $session = new \Sociate\Http\Session($this->container['db']);
        $this->assertNull($session->someKey);
        
        $session->someKey = 'data';
        $this->assertNull($session->someOtherKey);
        
        $this->assertEquals('data',$session->someKey);
    }
}