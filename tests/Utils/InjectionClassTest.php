<?php

/*
 * DokudoiBundle
 */

namespace tests\Alkahest\Utils;

use Trismegiste\Alkahest\Utils\InjectionClass;

/**
 * InjectionClassTest tests a normal behavior with internal type
 */
class InjectionClassTest extends \PHPUnit\Framework\TestCase {

    public function testErrorWhenNoWakeup() {
        $refl = new InjectionClass('DateTime');
        $obj = $refl->newInstanceWithoutConstructor();
        $this->assertInstanceOf(\DateTime::class, $obj);
    }

    public function testInjectProperty() {
        $obj = (object) [];
        $sut = new InjectionClass($obj);
        $sut->injectProperty($obj, 'answer', 42);
        $this->assertEquals(42, $obj->answer);
    }

}
