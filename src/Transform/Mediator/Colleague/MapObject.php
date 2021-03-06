<?php

/*
 * Alkahest
 */

namespace Trismegiste\Alkahest\Transform\Mediator\Colleague;

/**
 * MapObject is a mapper to and from an object
 * Must be responsible before MapArray (when in mapFromDb)
 */
class MapObject extends ObjectMapperTemplate {

    const FQCN_KEY = '-fqcn';

    /**
     * {@inheritDoc}
     */
    protected function extractFqcn(array &$param) {
        $fqcn = $param[self::FQCN_KEY];
        if (!class_exists($fqcn)) {
            throw new \DomainException("Cannot restore a '$fqcn' : class does not exist");
        }
        unset($param[self::FQCN_KEY]);

        return $fqcn;
    }

    /**
     * {@inheritDoc}
     */
    protected function prepareDump(\ReflectionObject $reflector) {
        $dump = array();
        $dump[self::FQCN_KEY] = $reflector->getName();

        return $dump;
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleFromDb($var): bool {
        return (gettype($var) == 'array') && array_key_exists(self::FQCN_KEY, $var);
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleToDb($var): bool {
        return gettype($var) == 'object';
    }

}
