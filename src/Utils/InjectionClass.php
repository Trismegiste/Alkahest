<?php

/*
 * Alkahest
 */

namespace Trismegiste\Alkahest\Utils;

/**
 * InjectionClass can dynamically
 * build object and properties
 */
class InjectionClass extends \ReflectionClass {

    /**
     * Set a property into an object, even it does not exist in the class
     * 
     * @param object $obj
     * @param string $key
     * @param mixed $value 
     */
    public function injectProperty(object $obj, string $key, $value) {
        if ($this->hasProperty($key)) {
            $prop = $this->getProperty($key);
            $prop->setAccessible(true);
            $prop->setValue($obj, $value);
        } else {
            $obj->$key = $value;
        }
    }

}
