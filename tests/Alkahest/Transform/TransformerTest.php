<?php

/*
 * Dokudoki
 */

namespace Trismegiste\Alkahest\Transform\Tests;

use Trismegiste\Alkahest\Transform\Transformer;
use Trismegiste\Alkahest\Transform\Delegation\MappingDirector;
use Trismegiste\Alkahest\Transform\Delegation\Stage\Neutral;
use tests\Alkahest\Fixtures\IntoVoid;

/**
 * TransformerTest test for Transformer
 *
 * @author florent
 */
class TransformerTest extends \PHPUnit_Framework_TestCase
{

    protected $service;

    protected function setUp()
    {
        $director = new MappingDirector();
        $this->service = new Transformer($director->create(new Neutral()));
    }

    protected function tearDown()
    {
        unset($this->service);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testOnlyObject()
    {
        $dump = $this->service->desegregate(array('nawak'));
    }

    /**
     * @expectedException \LogicException
     */
    public function testSkippable()
    {
        $obj = new IntoVoid();
        $dump = $this->service->desegregate($obj);
    }

    /**
     * The tranformer MUST return an object
     *
     * @expectedException \RuntimeException
     */
    public function testExceptionForBadCreation()
    {
        $this->service->create(array('bazinga' => 73));
    }

}
