<?php

/*
 * Alkahest
 */

namespace Trismegiste\Alkahest\Transform\Mediator\Colleague;

use Trismegiste\Alkahest\Transform\Mediator\AbstractMapper;

/**
 * MapScalar is a mapper to and from a scalar
 */
class MapScalar extends AbstractMapper {

    protected $scalarType = array('boolean', 'integer', 'double', 'string');

    /**
     * {@inheritDoc}
     */
    public function mapFromDb($var) {
        return $var;
    }

    /**
     * {@inheritDoc}
     */
    public function mapToDb($var) {
        return $var;
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleFromDb($var): bool {
        return in_array(gettype($var), $this->scalarType);
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleToDb($var): bool {
        return $this->isResponsibleFromDb($var);
    }

}
