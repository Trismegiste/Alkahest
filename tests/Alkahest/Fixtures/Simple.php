<?php

/*
 * Dokudokibundle
 */

namespace tests\Alkahest\Fixtures;

use Trismegiste\Alkahest\Persistence\Persistable;
use Trismegiste\Alkahest\Persistence\PersistableImpl;

class Simple implements Persistable
{

    use PersistableImpl;

    public $answer;

}