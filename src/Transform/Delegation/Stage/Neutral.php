<?php

/*
 * Alkahest
 */

namespace Trismegiste\Alkahest\Transform\Delegation\Stage;

use Trismegiste\Alkahest\Transform\Mediator\Colleague;
use Trismegiste\Alkahest\Transform\Mediator\TypeRegistry;

/**
 * Design Pattern : Builder
 * Component : Builder (concrete)
 */
class Neutral extends AbstractStage {

    public function createObject(TypeRegistry $algo): void {
        new Colleague\MapSkippable($algo);
        new Colleague\PhpCollection($algo);
        new Colleague\InvariantObject($algo, ['DateTime']);
        new Colleague\MapObject($algo);
    }

}
