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
 */
class TransformerTest extends \PHPUnit\Framework\TestCase {

    protected $service;

    protected function setUp(): void {
        $director = new MappingDirector();
        $this->service = new Transformer($director->create(new Neutral()));
    }

    protected function tearDown(): void {
        unset($this->service);
    }

    public function testOnlyObject() {
        $this->expectException(\InvalidArgumentException::class);
        $dump = $this->service->desegregate(array('nawak'));
    }

    public function testSkippable() {
        $this->expectException(\LogicException::class);
        $obj = new IntoVoid();
        $dump = $this->service->desegregate($obj);
    }

    /**
     * The tranformer MUST return an object
     */
    public function testExceptionForBadCreation() {
        $this->expectException(\RuntimeException::class);
        $this->service->create(array('bazinga' => 73));
    }

}
