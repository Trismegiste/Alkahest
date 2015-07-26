<?php

/*
 * Alkahest
 */

namespace tests\Alkahest\Persistence;

use Trismegiste\Alkahest\Persistence\Repository;
use Trismegiste\Alkahest\Facade\Provider;
use Trismegiste\Alkahest\Persistence\Persistable;

/**
 * Test Template for repository
 *
 * @author flo
 */
abstract class RepositoryTestTemplate extends \PHPUnit_Framework_TestCase
{

    protected $collection;
    protected $repo;

    abstract protected function createBuilder();

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
    }

    /**
     * @expectedException \Trismegiste\Alkahest\Persistence\NotFoundException
     */
    public function testNotFound()
    {
        $obj = $this->repo->findByPk('49a702d5450046d3d515d10d');
    }

    abstract protected function getSimpleObject();

    /**
     * @depends testInit
     */
    public function testCreation()
    {
        $simple = $this->getSimpleObject();
        $this->assertNull($simple->getId());
        $this->repo->persist($simple);
        $this->assertInstanceOf('\MongoId', $simple->getId());

        return (string) $simple->getId();
    }

    abstract protected function assertSimpleInsert(array $struc);

    /**
     * @depends testCreation
     */
    public function testInsert($pk)
    {
        $found = $this->collection->findOne(array('_id' => new \MongoId($pk)));
        $this->assertNotNull($found);
        $this->assertInternalType('array', $found);
        $this->assertSimpleInsert($found);

        return $pk;
    }

    /**
     * @depends testInsert
     */
    public function testRestore($pk)
    {
        $obj = $this->getSimpleObject();
        $obj->setId(new \MongoId($pk));
        $found = $this->repo->findByPk($pk);
        $this->assertEquals($obj, $found);

        return $obj;
    }

    abstract protected function editSimpleObject($obj);

    /**
     * @depends testRestore
     */
    public function testUpdate($obj)
    {
        $pk = $obj->getId();
        $this->editSimpleObject($obj);
        $this->repo->persist($obj);
        $this->assertEquals($pk, $obj->getId());

        return (string) $obj->getId();
    }

    abstract protected function assertEditedObject($obj);

    /**
     * @depends testUpdate
     */
    public function testUpdated($pk)
    {
        $obj = $this->repo->findByPk($pk);
        $this->assertEditedObject($obj);
    }

    abstract public function getComplexObject();

    /**
     * @dataProvider getComplexObject
     */
    public function testCycle($obj, $dump)
    {
        $this->assertNull($obj->getId());
        $this->repo->persist($obj);
        $this->assertInstanceOf('\MongoId', $obj->getId());
        // db
        $found = $this->collection->findOne(array('_id' => $obj->getId()));
        unset($found['_id']);
        $this->assertEquals($dump, $found);
        // restore
        $found = $this->repo->findByPk($obj->getId());
        $this->assertEquals($obj, $found);
    }

    public function testFindOne()
    {
        $restore = $this->repo->findOne($this->getQueryForComplexObject());
        $this->assertNotNull($restore);
    }

    public function testNotFindOne()
    {
        $restore = $this->repo->findOne(['-fqcn' => 'undefined']);
        $this->assertNull($restore);
    }

    /**
     * @dataProvider getComplexObject
     */
    public function testCursor($doc)
    {
        $this->repo->persist($doc);
        $cursor = $this->repo->getCursor($this->getQueryForComplexObject());
        $this->assertCount(2, $cursor);
    }

    abstract protected function getQueryForComplexObject();

    public function testCollectionIterator()
    {
        $cursor = $this->repo->find($this->getQueryForComplexObject());

        $this->assertCount(2, $cursor);
        foreach ($cursor as $dontcare => $obj) {
            $this->assertTrue($obj instanceof Persistable);
        }
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage stdClass is not Persistable
     */
    public function testNotRestoringNonPersistable()
    {
        $collection = $this->getMockBuilder('MongoCollection')
                ->disableOriginalConstructor()
                ->setMethods(array('findOne'))
                ->getMock();
        $collection->expects($this->once())
                ->method('findOne')
                ->will($this->returnValue(array('_id' => $this->getMock('MongoId'))));

        $factory = $this->getMockBuilder('Trismegiste\Alkahest\Transform\Transformer')
                ->disableOriginalConstructor()
                ->getMock();
        $factory->expects($this->once())
                ->method('create')
                ->will($this->returnValue(new \stdClass()));
        $repo = new Repository($collection, $factory);
        $repo->findByPk('49a702d5450046d3d515d10d');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The database entry does not have a primary key
     */
    public function testNotCreatingInvalidData()
    {
        $collection = $this->getMockBuilder('MongoCollection')
                ->disableOriginalConstructor()
                ->getMock();

        $factory = $this->getMockBuilder('Trismegiste\Alkahest\Transform\Transformer')
                ->disableOriginalConstructor()
                ->getMock();
        $repo = new Repository($collection, $factory);
        $repo->createFromDb(array());
    }

    /**
     * @depends testInit
     */
    public function testBatchInsert()
    {
        $batch = [
            $this->getSimpleObject(),
            $this->getSimpleObject()
        ];

        $this->repo->batchPersist($batch);
        foreach ($batch as $obj) {
            $this->assertInstanceOf('\MongoId', $obj->getId());
        }
    }

    /**
     * @depends testInit
     */
    public function testBatchInsertWithId()
    {
        $batch = [
            $this->getSimpleObject(),
            $this->getSimpleObject()
        ];

        $batch[0]->setId(new \MongoId());
        $batch[1]->setId(new \MongoId());

        $this->repo->batchPersist($batch);
    }

}
