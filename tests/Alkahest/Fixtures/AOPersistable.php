<?php

namespace tests\Alkahest\Fixtures;

use Trismegiste\Alkahest\Persistence\Persistable;
use Trismegiste\Alkahest\Persistence\PersistableImpl;

class AOPersistable
{

    // we must wrap the ArrayObject and cannot extends it because PHP
    // cannot create internal class without calling the constructor
    protected $collection;

    public function __construct(array $array = [])
    {
        $this->collection = new \ArrayObject($array);
    }

    public function getCollection()
    {
        return $this->collection;
    }

}
