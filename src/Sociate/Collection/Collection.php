<?php
namespace Sociate\Collection;

class Collection
{
    /**
     * 
     * @var \MongoDB\Collection
     */
    protected $collection;
    
    public function __construct(\MongoDB\Collection $collection)
    {
        $this->collection = $collection;
    }
    
    public function getName()
    {
        return $this->collection->getCollectionName();
    }
    
    public function findOne($filter = [], array $options = [])
    {
        return $this->collection->findOne($filter,$options);
    }
    
    public function replaceOne($filter, $replacement, array $options = [])
    {
        return $this->collection->replaceOne($filter, $replacement,$options);
    }
}