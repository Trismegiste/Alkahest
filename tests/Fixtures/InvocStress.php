<?php

/*
 * Dokudokibundle
 */

namespace tests\Alkahest\Fixtures;

class InvocStress extends Simple
{

// silly names to track bug
    protected $floatVar;
    protected $binaryVar;
    protected $dateVar;
    protected $stringVar;
    protected $intVar;
    protected $objVar;
    static public $iDontLikeStatic = "dark matter";

    public function __construct()
    {
        $this->answer = 42;
        $this->floatVar = 3.14159265; // don't know after that
        $this->dateVar = new \DateTime('2013-02-14 08:20:08');
        $this->intVar = 73; // the best number
        $this->stringVar = 'H Psi = E . Psi';
        $this->objVar = new Simple();
        $this->objVar->answer = 'eureka';
        $this->vector = array(1, 2, 3);
    }

}