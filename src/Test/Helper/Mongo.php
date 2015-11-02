<?php
namespace Test\Helper;

defined('TEST_ROOT') || define('TEST_ROOT',__DIR__.'/../../../tests/');

class Mongo
{
    /**
     *
     * @var array
     */
    protected $config;
    /**
     *
     * @var \Slim\Container
     */
    protected $container;
    
    /**
     * 
     * @var \MongoDB
     */
    protected $db;
    
    public function __construct()
    {
        $this->config = require TEST_ROOT.'/../config/config.php';
        $this->container = require TEST_ROOT. '/../config/container.php';
        $this->container['config'] = $this->config;
        
        $this->db = $this->container['db'];
    }
    
    public function dropCollection($collection)
    {
        $this->db->{$collection}->drop();
    }
    
    public function addToCollection($collection,$data)
    {
        $this->db->{$collection}->insert($data);
    }
    
    public function seeInCollection($collection,$criteria)
    {
        return $this->db->{$collection}->find($criteria);
    }
}