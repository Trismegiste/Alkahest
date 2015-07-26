<?php

/*
 * Alkahest
 */

namespace tests\Alkahest\Persistence;

use Trismegiste\Alkahest\Persistence\Repository;
use tests\Alkahest\Fixtures;
use Trismegiste\Alkahest\Transform\Mediator\Colleague\MapObject;

/**
 * Test repository with Invocation stage
 *
 * @author flo
 */
class RepositoryInvocationTest extends RepositoryTestTemplate
{

    protected function createBuilder()
    {
        return new \Trismegiste\Alkahest\Transform\Delegation\Stage\Invocation();
    }

    protected function getSimpleObject()
    {
        $obj = new \tests\Alkahest\Fixtures\Simple();
        $obj->answer = 42;
        return $obj;
    }

    protected function assertSimpleInsert(array $struc)
    {
        $this->assertEquals(42, $struc['answer']);
    }

    protected function editSimpleObject($obj)
    {
        $obj->answer = 73;
    }

    protected function assertEditedObject($obj)
    {
        $this->assertEquals(73, $obj->answer);
    }

    public function getComplexObject()
    {
        $obj = new \tests\Alkahest\Fixtures\InvocStress();
        $tmp = new \DateTime('2013-02-14 08:20:08');
        $dump = array(
            MapObject::FQCN_KEY => 'tests\Alkahest\\Fixtures\\InvocStress',
            'floatVar' => 3.14159265,
            'binaryVar' => new \MongoBinData('299792458', 2),
            'dateVar' => new \MongoDate($tmp->getTimestamp(), 0),
            'stringVar' => 'H Psi = E . Psi',
            'intVar' => 73,
            'objVar' => array(
                MapObject::FQCN_KEY => 'tests\Alkahest\\Fixtures\\Simple',
                'id' => NULL,
                'answer' => 'eureka',
            ),
            'answer' => 42,
            'vector' => array(1, 2, 3)
        );
        return array(array($obj, $dump));
    }

    /**
     * @expectedException LogicException
     * @expectedExceptionMessage A root entity cannot be Skippable
     */
    public function testSkippableRoot()
    {
        $obj = new Fixtures\NonSense();
        $this->repo->persist($obj);
    }

    protected function getQueryForComplexObject()
    {
        return ['objVar.answer' => 'eureka'];
    }

    
    
}
