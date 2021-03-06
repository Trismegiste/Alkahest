<?php

/*
 * Alkahest
 */

namespace Trismegiste\Alkahest\Transform\Mediator\Colleague;

use Trismegiste\Alkahest\Transform\Mediator\AbstractMapper;

/**
 * Design Pattern : Mediator
 * Component : Colleague (concrete)
 *
 * MapArray deals the mapping with arrays
 */
class MapArray extends AbstractMapper {

    /**
     * {@inheritDoc}
     */
    public function mapFromDb($param) {
        return array_map(array($this->mediator, 'recursivCreate'), $param);
    }

    /**
     * {@inheritDoc}
     */
    public function mapToDb($arr) {
        return array_map(array($this->mediator, 'recursivDesegregate'), $arr);
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleFromDb($var): bool {
        return 'array' == gettype($var);
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleToDb($var): bool {
        return 'array' == gettype($var);
    }

}
