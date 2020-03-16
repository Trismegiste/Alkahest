<?php

/*
 * Alkahest ◕ ‿‿ ◕
 */

namespace Trismegiste\Alkahest\Transform;

use Trismegiste\Alkahest\Transform\Mediator\RecursiveMapper;

/**
 * Factory is a transformer to translate object to array and vice versa
 */
class Transformer implements TransformerInterface {

    protected $delegation;

    public function __construct(RecursiveMapper $algo) {
        $this->delegation = $algo;
    }

    /**
     * {@inheritDoc}
     */
    public function desegregate(object $obj): array {
        if ($obj instanceof Skippable) {
            throw new \LogicException('A root entity cannot be Skippable');
        }

        return $this->delegation->recursivDesegregate($obj);
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $dump): object {
        $obj = $this->delegation->recursivCreate($dump);
        if (gettype($obj) != 'object') {
            throw new \RuntimeException('The root entity is not an object');
            // SRP : only Mediator knows if $dump will be an object or not
        }

        return $obj;
    }

}
