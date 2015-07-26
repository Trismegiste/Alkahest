<?php

/*
 * Alkahest
 */

namespace tests\Alkahest;

use Trismegiste\Alkahest\Transform\Delegation\MappingDirector;
use Trismegiste\Alkahest\Transform\Delegation\Stage\Neutral;
use Trismegiste\Alkahest\Transform\Transformer;

/**
 * DumperExample gives example of the serializing process
 */
class DumperExampleTest extends \PHPUnit_Framework_TestCase
{

    protected $transform;

    protected function setUp()
    {
        $director = new MappingDirector();
        $mappingChain = $director->create(new Neutral());
        $this->transform = new Transformer($mappingChain);
    }

    /**
     * Transforms a complex object with non-empty constructor to
     * a recursive array
     */
    public function testSerialize()
    {
        $product = new LightSaber('red');
        $product->setOwner(new Owner('vader'));
        $dump = $this->transform->desegregate($product);
        $this->assertEquals([
            '-fqcn' => 'tests\\Alkahest\\LightSaber',
            'color' => 'red',
            'owner' => [
                '-fqcn' => 'tests\\Alkahest\\Owner',
                'name' => 'vader',
            ],
                ], $dump);
    }

    /**
     * Creates a complex object with non-empty constructor from
     * a recursive array
     */
    public function testUnserialize()
    {
        $dump = [
            '-fqcn' => 'tests\\Alkahest\\LightSaber',
            'color' => 'red',
            'owner' => [
                '-fqcn' => 'tests\\Alkahest\\Owner',
                'name' => 'vader',
            ],
        ];
        $product = $this->transform->create($dump);
        $this->assertInstanceOf(__NAMESPACE__ . '\LightSaber', $product);
        $this->assertEquals('red', $product->getColor());
        $this->assertEquals('vader', $product->getOwnerName());
    }

}

//////////////////////////////
// some example class
class LightSaber
{

    protected $color;
    protected $owner;

    public function __construct($c)
    {
        $this->color = $c;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setOwner(Owner $own)
    {
        $this->owner = $own;
    }

    public function getOwnerName()
    {
        return $this->owner->getName();
    }

}

class Owner
{

    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

}