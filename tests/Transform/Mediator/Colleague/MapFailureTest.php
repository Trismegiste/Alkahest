<?php

/*
 * Alkahest
 */

namespace tests\Alkahest\Transform\Mediator\Colleague;

use PHPUnit\Framework\TestCase;
use Trismegiste\Alkahest\Transform\MappingException;
use Trismegiste\Alkahest\Transform\Mediator\Colleague\MapFailure;

/**
 * Design pattern : Template method
 * MapFailureTest tests for MapFailure (catches mapping problems)
 */
class MapFailureTest extends TestCase {

    protected $mapper;

    protected function setUp(): void {
        $mediator = $this->getMockForAbstractClass('Trismegiste\Alkahest\Transform\Mediator\AbstractMediator');
        $this->mapper = new MapFailure($mediator);
    }

    protected function tearDown(): void {
        unset($this->mapper);
    }

    public function testMapFromDb() {
        $this->expectException(MappingException::class);
        $this->expectExceptionMessage('restoration');
        $obj = $this->mapper->mapFromDb(123);
    }

    public function testMapToDb() {
        $this->expectException(MappingException::class);
        $this->expectExceptionMessage('persistence');
        $dump = $this->mapper->mapToDb(123);
    }

    public function testResponsibleToDb() {
        $this->assertTrue($this->mapper->isResponsibleToDb(123));
    }

    public function testResponsibleFromDb() {
        $this->assertTrue($this->mapper->isResponsibleFromDb(123));
    }

}
