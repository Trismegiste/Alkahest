<?php

/*
 * Dokudokibundle
 */

namespace tests\Alkahest\Fixtures;

/**
 * Leaf is a fixture class for migration tests
 */
class Leaf
{

    protected $data;

    public function addValue($key, $value)
    {
        $this->data[$key] = $value;
    }

}