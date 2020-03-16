<?php

/*
 * Alkahest
 */

namespace tests\Alkahest\Transform\Mediator\Colleague;

use LogicException;
use stdClass;
use tests\Alkahest\Fixtures\IntoVoid;
use Trismegiste\Alkahest\Transform\Mediator\AbstractMediator;
use Trismegiste\Alkahest\Transform\Mediator\Colleague\MapSkippable;
use Trismegiste\Alkahest\Transform\Skippable;

/**
 * MapSkippableTest is a test for transient class
 */
class MapSkippableTest extends MapperTestTemplate {

    protected function createMapper() {
        $mediator = $this->getMockForAbstractClass(AbstractMediator::class);
        return new MapSkippable($mediator);
    }

    public function getDataFromDb() {
        
    }

    public function getResponsibleDataFromDb() {
        
    }

    public function testResponsibleFromDb($var = null) {
        $this->assertFalse($this->mapper->isResponsibleFromDb(42));
    }

    public function testMapFromDb($src = null, $dest = null) {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('There is a bug here');
        $obj = $this->createStub(Skippable::class);
        $this->mapper->mapFromDb($obj);
    }

    public function getDataToDb() {
        return array(array(new IntoVoid(), null));
    }

    public function getNotResponsibleDataFromDb() {
        return array(array(42));
    }

    public function getNotResponsibleDataToDb() {
        return array(array(new stdClass()), array(42));
    }

    public function getResponsibleDataToDb() {
        return array(array(new IntoVoid()));
    }

}
