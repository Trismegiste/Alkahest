<?php

/*
 * Alkahest
 */

namespace Trismegiste\Alkahest\Facade;

use Trismegiste\Alkahest\Transform\Mediator\RecursiveMapper;

/**
 * Provider is a concrete & highly coupled facade for this bundle
 * It creates Repository 
 */
class Provider extends AbstractProvider
{

    protected function createDirector()
    {
        return new \Trismegiste\Alkahest\Transform\Delegation\MappingDirector();
    }

    protected function createTransformer(RecursiveMapper $mapper)
    {
        return new \Trismegiste\Alkahest\Transform\Transformer($mapper);
    }

}