<?php

/*
 * Dokudoki
 */

namespace tests\Alkahest\Fixtures;

class Product
{

    private $title;
    protected $price = 0;

    public function __construct($tit, $pri)
    {
        $this->title = $tit;
        $this->price = $pri;
    }

}
