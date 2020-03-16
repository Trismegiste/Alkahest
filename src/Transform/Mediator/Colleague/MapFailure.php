<?php

/*
 * Alkahest
 */

namespace Trismegiste\Alkahest\Transform\Mediator\Colleague;

use Trismegiste\Alkahest\Transform\Mediator\AbstractMapper;
use Trismegiste\Alkahest\Transform\MappingException;

/**
 * MapFailure is the last mapper which throws exception when no other mapper
 * is responsible.
 */
class MapFailure extends AbstractMapper
{

    /**
     * {@inheritDoc}
     */
    public function mapFromDb($var)
    {
        throw new MappingException($var, 'restoration');
    }

    /**
     * {@inheritDoc}
     */
    public function mapToDb($var)
    {
        throw new MappingException($var, 'persistence');
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleFromDb($var)
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleToDb($var)
    {
        return true;
    }

}