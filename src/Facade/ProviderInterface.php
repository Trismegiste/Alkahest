<?php

/*
 * Alkahest
 */

namespace Trismegiste\Alkahest\Facade;

use Trismegiste\Alkahest\Transform\Delegation\MappingBuilder;

/**
 * Design Pattern: Factory Method
 * ProviderInterface is a contract for providing repository
 */
interface ProviderInterface
{

    /**
     * Creates a new instance of a repository with a builder for the mapping
     * 
     * @param MappingBuilder $builder the builder of mapping
     * 
     * @return Trismegiste\Alkahest\Persistence\RepositoryInterface
     */
    function createRepository(MappingBuilder $builder);
}