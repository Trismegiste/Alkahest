<?php

/*
 * Dokudokibundle
 */

namespace tests\Alkahest\Fixtures;

class CartPlus implements \IteratorAggregate {

    protected $row;

    public function __construct() {
        $this->row = new \SplObjectStorage();
    }

    public function addItem($qt, $pro) {
        $this->row[$pro] = $qt;
    }

    public function getIterator() {
        return $this->row;
    }

    public function getQty($pro) {
        return $this->row[$pro];
    }

}
