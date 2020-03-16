<?php

/*
 * Alkahest
 */

namespace tests\Alkahest\Transform\Mediator\Colleague;

use Trismegiste\Alkahest\Transform\Mediator\Colleague\MapSkippable;
use tests\Alkahest\Fixtures\IntoVoid;

/**
 * MapSkippableTest is a test for transient class
 *
 * @author florent
 */
class MapSkippableTest extends MapperTestTemplate
{

    protected function createMapper()
    {
        $mediator = $this->getMockForAbstractClass('Trismegiste\Alkahest\Transform\Mediator\AbstractMediator');
        return new MapSkippable($mediator);
    }

    public function getDataFromDb() {}
    public function getResponsibleDataFromDb() {}
    public function testResponsibleFromDb($var=null) {}

    /**
     * @expectedException LogicException
     * @expectedExceptionMessage There is a bug here
     */
    public function testMapFromDb($src=null, $dest=null)
    {
        $obj = $this->getMock('Trismegiste\Alkahest\Transform\Skippable');
        $this->mapper->mapFromDb($obj);
    }

    public function getDataToDb()
    {
        return array(array(new IntoVoid(), null));
    }

    public function getNotResponsibleDataFromDb()
    {
        return array(array(42));
    }

    public function getNotResponsibleDataToDb()
    {
        return array(array(new \stdClass()), array(42));
    }

    public function getResponsibleDataToDb()
    {
        return array(array(new IntoVoid()));
    }

}