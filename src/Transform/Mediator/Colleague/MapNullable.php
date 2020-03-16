<?php

/*
 * Alkahest
 */

namespace Trismegiste\Alkahest\Transform\Mediator\Colleague;

use Trismegiste\Alkahest\Transform\Mediator\AbstractMapper;

/**
 * Nullable is a mapper to and from a nullable : null and resource
 */
class MapNullable extends AbstractMapper {

    /**
     * {@inheritDoc}
     */
    public function mapFromDb($var) {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function mapToDb($var) {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleFromDb($var): bool {
        return gettype($var) == 'NULL';
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleToDb($var): bool {
        return in_array(gettype($var), array('NULL', 'resource'));
    }

}
