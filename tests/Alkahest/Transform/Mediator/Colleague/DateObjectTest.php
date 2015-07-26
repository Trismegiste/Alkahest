<?php

/*
 * Alkahest
 */

namespace tests\Alkahest\Transform\Mediator\Colleague;

use Trismegiste\Alkahest\Transform\Mediator\Colleague\DateObject;
use Trismegiste\Alkahest\Transform\Mediator\Colleague\MapObject;

/**
 * Test for DateObject
 *
 * @author flo
 */
class DateObjectTest extends MapperTestTemplate
{

    protected function createMapper()
    {
        return new DateObject($this->createMediatorMockup());
    }

    public function getDataFromDb()
    {
        return array(array(new \MongoDate(), new \DateTime()));
    }

    public function getDataToDb()
    {
        return array(array(new \DateTime(), new \MongoDate(time(), 0)));
    }

    public function getResponsibleDataToDb()
    {
        return array(array(new \DateTime()));
    }

    public function getResponsibleDataFromDb()
    {
        return array(array(new \MongoDate()));
    }

    public function getNotResponsibleDataToDb()
    {
        return array(array(new \stdClass()), array(new \MongoDate()));
    }

    public function getNotResponsibleDataFromDb()
    {
        return array(array(new \DateTime()), array(array(MapObject::FQCN_KEY => 'DateTime')));
    }

    /**
     * Logically this case never happen, anyway it's a double check for futher
     * evolution which could break this mapper behavior
     * 
     * @expectedException LogicException
     */
    public function testMapMongoDateToDb()
    {
        $date = new \MongoDate();
        $this->assertFalse($this->mapper->isResponsibleToDb($date));
        $dump = $this->mapper->mapToDb($date);
    }

}