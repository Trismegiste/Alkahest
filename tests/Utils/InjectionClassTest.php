<?php

/*
 * DokudoiBundle
 */

namespace tests\Alkahest\Utils;

use Trismegiste\Alkahest\Utils\InjectionClass;

/**
 * InjectionClassTest tests a normal behavior with internal type
 */
class InjectionClassTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @expectedException ReflectionException
     */
    public function testErrorWhenNoWakeup()
    {
        $refl = new InjectionClass('DateTime');
        $obj = $refl->newInstanceWithoutConstructor();
    }

}

