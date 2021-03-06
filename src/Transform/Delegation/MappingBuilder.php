<?php

/*
 * Alkahest
 */

namespace Trismegiste\Alkahest\Transform\Delegation;

use Trismegiste\Alkahest\Transform\Mediator\TypeRegistry;

/**
 * Design Pattern : Builder
 * Component : Builder (abstract)
 *
 * This is a contract for a builder of delegation of mapping
 * @see Mediator
 */
interface MappingBuilder {

    /**
     * Create the chain of algorithms of mapping
     *
     * @return TypeRegistry
     */
    function createChain(): TypeRegistry;

    /**
     * Register mappers for non-object (scalar, null, array...)
     *
     * @param TypeRegistry $algo
     */
    function createNonObject(TypeRegistry $algo): void;

    /**
     * Register mappers for object
     *
     * @param TypeRegistry $algo
     */
    function createObject(TypeRegistry $algo): void;

    /**
     * Register mappers for database conversion (date, blob...)
     *
     * @param TypeRegistry $algo
     */
    function createDbSpecific(TypeRegistry $algo): void;

    /**
     * Registers the end of mapping chain
     * Usually throws an exception but it's up to you to silently
     * skip a mapping problem.
     *
     * @param TypeRegistry $algo
     */
    function createBlackHole(TypeRegistry $algo): void;
}
