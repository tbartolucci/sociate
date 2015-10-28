<?php
namespace phpunit\Sociate;

class ContainerAwareTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \Sociate\ContainerAware::__construct
     * @covers \Sociate\ContainerAware::getContainer
     * @covers \Sociate\ContainerAware::setContainer
     */
    public function testGetterSetter()
    {
        $container = new \Slim\Container();
        
        $aware = new \Sociate\ContainerAware($container);
        $this->assertSame($container,$aware->getContainer());
        
        $container2 = new \Slim\Container();
        $aware->setContainer($container2);
        
        $this->assertSame($container2,$aware->getContainer());
    }
}