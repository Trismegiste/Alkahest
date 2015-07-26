<?php

/*
 * Alkahest
 */

namespace tests\Alkahest\Persistence;

/**
 * DecoratorTest tests the decorator
 */
class DecoratorTest extends \PHPUnit_Framework_TestCase
{

    protected $sut;

    protected function setUp()
    {
        $mock = $this->getMock('Trismegiste\Alkahest\Persistence\RepositoryInterface');
        $this->sut = $this->getMockForAbstractClass('Trismegiste\Alkahest\Persistence\Decorator', [$mock]);
    }

    public function testQuery()
    {
        $this->sut->find();
        $this->sut->findOne();
        $this->sut->findByPk(123);
        $this->sut->getCursor();
    }

    public function testPersistence()
    {
        $this->sut->createFromDb([]);
        $this->sut->persist($this->getMock('Trismegiste\Alkahest\Persistence\Persistable'));
    }

    public function testBatchPersist()
    {
        $this->sut->batchPersist([]);
    }

}