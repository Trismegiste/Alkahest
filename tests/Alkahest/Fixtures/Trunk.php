<?php

/*
 * Dokudokibundle
 */

namespace tests\Alkahest\Fixtures;

use Trismegiste\Alkahest\Persistence\Persistable;

/**
 * Trunk is a fixture class for migration tests
 */
class Trunk extends Branch implements Persistable
{

    use \Trismegiste\Alkahest\Persistence\PersistableImpl;
}