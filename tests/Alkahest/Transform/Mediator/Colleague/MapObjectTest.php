<?php

/*
 * Alkahest
 */

namespace tests\Alkahest\Transform\Mediator\Colleague;

use Trismegiste\Alkahest\Transform\Mediator\Colleague\MapObject;
use Trismegiste\Alkahest\Transform\Mediator\Mediator;

/**
 * Test for MapObject
 *
 * @author flo
 */
class MapObjectTest extends MapperTestTemplate
{

    protected function createMapper()
    {
        return new MapObject($this->createMediatorMockup());
    }

    public function getDataFromDb()
    {
        $obj = new \stdClass();
        $obj->answer = 42;
        $dump = array(MapObject::FQCN_KEY => 'stdClass', 'answer' => 42);
        return array(array($dump, $obj));
    }

    public function getDataToDb()
    {
        $obj = new \stdClass();
        $obj->answer = 42;
        $dump = array(MapObject::FQCN_KEY => 'stdClass', 'answer' => 42);
        return array(array($obj, $dump));
    }

    public function getResponsibleDataToDb()
    {
        return array(array(new \stdClass()));
    }

    public function getResponsibleDataFromDb()
    {
        return array(array(array(MapObject::FQCN_KEY => 'hello')));
    }

    public function getNotResponsibleDataToDb()
    {
        return array(array(null), array(42), array(array('hello')));
    }

    public function getNotResponsibleDataFromDb()
    {
        return array(array(null), array(array('prop' => 'hello')), array(new \MongoDate()));
    }

    /**
     * @expectedException DomainException
     * @expectedExceptionMessage does not exist
     */
    public function testNotFound()
    {
        $mapper = $this->createMapper();
        $dump = array(MapObject::FQCN_KEY => 'NotFound', 'answer' => 42);
        $mapper->mapFromDb($dump);
    }

}