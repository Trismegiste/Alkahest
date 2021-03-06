<?php

/*
 * Alkahest
 */

namespace Trismegiste\Alkahest\Transform\Mediator;

/**
 * Design Pattern : Mediator
 * Component : Mediator (abstract)
 *
 * Responsible for maintaining a list of Colleague
 */
abstract class AbstractMediator implements RecursiveMapper, TypeRegistry {

    protected $mappingColleague = [];

    /**
     * {@inheritDoc}
     *
     * You must note that order of registering matters :
     * The first colleague which said "I'll do it" will be the first
     * to work no matter others colleague.
     */
    public function registerType(Mapping $colleague): void {
        $this->mappingColleague[] = $colleague;
    }

}
