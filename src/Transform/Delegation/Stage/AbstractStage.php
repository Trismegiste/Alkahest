<?php

/*
 * Alkahest
 */

namespace Trismegiste\Alkahest\Transform\Delegation\Stage;

use Trismegiste\Alkahest\Transform\Mediator\Mediator;
use Trismegiste\Alkahest\Transform\Mediator\Colleague;
use Trismegiste\Alkahest\Transform\Delegation\MappingBuilder;
use Trismegiste\Alkahest\Transform\Mediator\TypeRegistry;

/**
 * Design Pattern : Builder
 * Component : Builder (abstract)
 *
 * This is a template for a builder of delegation of mapping
 * @see Transformer
 *
 * @author flo
 */
abstract class AbstractStage implements MappingBuilder {

    /**
     * {@inheritDoc}
     */
    public function createChain(): TypeRegistry {
        return new Mediator();
    }

    /**
     * {@inheritDoc}
     */
    public function createNonObject(TypeRegistry $algo) {
        new Colleague\MapArray($algo);
        new Colleague\MapScalar($algo);
        new Colleague\MapNullable($algo);
    }

    /**
     * {@inheritDoc}
     */
    public function createDbSpecific(TypeRegistry $algo) {
        
    }

    /**
     * {@inheritDoc}
     * Default adapter for implementation of the interface
     */
    public function createBlackHole(TypeRegistry $algo) {
        
    }

}
