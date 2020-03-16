<?php

/*
 * Alkahest
 */

namespace Trismegiste\Alkahest\Transform\Mediator;

/**
 * Contract for registering a type name with a mapper object
 */
interface TypeRegistry {

    /**
     * Register the type name (php) with a mapper object
     *
     * @param Mapping $colleague the mapper (usually a colleague from a Mediator Pattern
     */
    function registerType(Mapping $colleague): void;
}
