<?php
namespace phpunit\Sociate\Http;

class SessionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * 
     * @var \Sociate\Collection\Collection
     */
    protected $sessions;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->sessions = $this->getMockBuilder('\Sociate\Collection\Collection')
            ->disableOriginalConstructor()
            ->getMock();
    }
    
    /**
     * @test
     * @covers \Sociate\Session::__construct
     */
    public function testConstructor()
    {
        $session = new \Sociate\Session($this->sessions);
        $this->assertInstanceOf('\Sociate\Session',$session);
    }
    
    /**
     * @test
     * @covers \Sociate\Session::load
     */
    public function testLoadFail()
    {
        $accessToken = '123124123adfasd';
        
        $this->sessions->expects($this->once())
            ->method('findOne')
            ->with(['token' => $accessToken])
            ->willReturn(null);
    
        $session = new \Sociate\Session($this->sessions);
        $this->assertFalse($session->load($accessToken));
    }
    
    /**
     * @test
     * @covers \Sociate\Session::load
     */
    public function testLoad()
    {
        $accessToken = '123124123adfasd';
        $session = [ 'token' => $accessToken , 'lastAccessed' => 'timestamp'];
        
        $this->sessions->expects($this->once())
            ->method('findOne')
            ->with(['token' => $accessToken])
            ->willReturn($session);
        
        $session = new \Sociate\Session($this->sessions);
        $this->assertTrue($session->load($accessToken));
    }
    
    /**
     * @test
     * @covers \Sociate\Session::write
     */
    public function testWrite()
    {
        $accessToken = '123124123adfasd';
        $data = [ 'token' => $accessToken , 'lastAccessed' => 'timestamp'];
        
        $this->sessions->expects($this->once())
            ->method('replaceOne')
            ->with(['token' => $accessToken],$data,['upsert'=>true])
            ->willReturn(true);
        
        $session = new \Sociate\Session($this->sessions);
        $session->token = $accessToken;
        $session->lastAccessed = 'timestamp';
        $this->assertTrue($session->write());
    }
    
    /**
     * @test
     * @covers \Sociate\Session::__set
     */
    public function testSet()
    {
        $session = new \Sociate\Session($this->sessions);
        $session->someKey = 'someData';
        $this->assertEquals('someData',$session->someKey);
    }
    
    /**
     * @test
     * @covers \Sociate\Session::__get
     */
    public function testGet()
    {
        $session = new \Sociate\Session($this->sessions);
        $this->assertNull($session->someKey);
        
        $session->someKey = 'data';
        $this->assertNull($session->someOtherKey);
        
        $this->assertEquals('data',$session->someKey);
    }
}