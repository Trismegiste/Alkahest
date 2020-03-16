<?php

/*
 * Alkahest
 */

namespace Trismegiste\Alkahest\Transform\Mediator\Colleague;

use Trismegiste\Alkahest\Transform\Mediator\AbstractMapper;
use Trismegiste\Alkahest\Transform\Skippable;

/**
 * MapSkippable is a mapper responsible for implementations of Skippable.
 * It overrides MapObject if following it
 */
class MapSkippable extends AbstractMapper {

    public function isResponsibleFromDb($var) {
        return false;
    }

    public function isResponsibleToDb($var) {
        return ('object' == gettype($var)) && ($var instanceof Skippable);
    }

    public function mapFromDb($var) {
        throw new \LogicException('There is a bug here');
    }

    public function mapToDb($var) {
        return null;
    }

}
