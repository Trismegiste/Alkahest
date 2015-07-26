<?php

/*
 * Dokudokibundle
 */

namespace tests\Alkahest\Fixtures;

use Trismegiste\Alkahest\Persistence\Persistable;

class Order extends Cart implements Persistable
{

    use \Trismegiste\Alkahest\Persistence\PersistableImpl;
}