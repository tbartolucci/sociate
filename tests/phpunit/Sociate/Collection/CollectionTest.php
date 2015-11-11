<?php
namespace phpunit\Sociate\Collection;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * 
     * @var \MongoDB\Collection
     */
    protected $mongoCollection;
    
    public function setUp()
    {
        parent::setUp();
        $this->mongoCollection = $this->getMockBuilder('\MongoDB\Collection')
            ->disableOriginalConstructor()
            ->getMock();
    }
    
    /**
     * @test
     * @covers \Sociate\Collection\Collection::getName
     */
    public function testgetName()
    {
        $expectedName = 'someCollection';
        
        $this->mongoCollection->expects($this->once())
            ->method('getCollectionName')
            ->willReturn($expectedName);
        
        $collection = new \Sociate\Collection\Collection($this->mongoCollection);
        $name = $collection->getName();
        
        $this->assertEquals($expectedName,$name);
    }
    
    /**
     * @test
     * @covers \Sociate\Collection\Collection::findOne
     */
    public function testFindOne()
    {
        $filter = [ 'id' => 'name' ];
        $options = [ 'some' => 'option' ];
        $expectedObj = new \StdClass();
        
        $this->mongoCollection->expects($this->once())
            ->method('findOne')
            ->with($filter,$options)
            ->willReturn($expectedObj);
        
        $collection = new \Sociate\Collection\Collection($this->mongoCollection);
        $obj = $collection->findOne($filter,$options); 
        $this->assertSame($expectedObj,$obj);
    }
    
    /**
     * @test
     * @covers \Sociate\Collection\Collection::replaceOne
     */
    public function testReplaceOne()
    {
        $filter = [ 'id' => 'name' ];
        $replacement = [ 'id' => 'name', 'username' => 'something'];
        $options = [ 'some' => 'option' ];
        $expectedObj = new \StdClass();
        
        $this->mongoCollection->expects($this->once())
            ->method('replaceOne')
            ->with($filter,$replacement,$options)
            ->willReturn($expectedObj);
        
        $collection = new \Sociate\Collection\Collection($this->mongoCollection);
        $obj = $collection->replaceOne($filter,$replacement, $options);
        $this->assertSame($expectedObj,$obj);
    }
}