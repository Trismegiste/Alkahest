<?php

/*
 * Alkahest
 */

namespace tests\Alkahest\Persistence;

use Trismegiste\Alkahest\Persistence\CollectionIterator;
use Trismegiste\Alkahest\Persistence\Repository;
use Trismegiste\Alkahest\Facade\Provider;

/**
 * CollectionIteratorTest tests 
 */
class CollectionIteratorTest extends \PHPUnit_Framework_TestCase
{

    protected $collection;
    protected $repo;

    protected function createBuilder()
    {
        return new \Trismegiste\Alkahest\Transform\Delegation\Stage\Invocation();
    }

    protected function setUp()
    {
        $test = new ConnectorTest();
        $this->collection = $test->testCollection();
        $facade = new Provider($this->collection);
        $this->repo = $facade->createRepository($this->createBuilder());
    }

    public function testInit()
    {
        $this->collection->drop();
        for ($k = 0; $k < 10; $k++) {
            $obj = new \tests\Alkahest\Fixtures\Person();
            $obj->data = $k;
            $this->repo->persist($obj);
        }

        $coll = $this->repo->find();
        $this->assertCount(10, $coll);
    }

    public function testLimit()
    {
        $coll = $this->repo->find()->limit(5);
        $this->assertCount(5, $coll);
    }

    public function testSort()
    {
        $it = $this->repo->find()->sort(['data' => -1]);
        $it->rewind();
        $first = $it->current();
        $this->assertEquals(9, $first->data);

        $it = $this->repo->find()->sort(['data' => 1]);
        $it->rewind();
        $first = $it->current();
        $this->assertEquals(0, $first->data);
    }

    public function testOffset()
    {
        $coll = $this->repo->find()->offset(5);
        $this->assertCount(5, $coll);
    }

}