<?php

/*
 * Dokudokibundle
 */

namespace tests\Alkahest\Transform\Mediator\Colleague;

use Trismegiste\Alkahest\Transform\Mediator\Colleague\PhpCollection;
use Trismegiste\Alkahest\Transform\Mediator\Colleague\MapObject;

/**
 * PhpCollectionTest tests PhpCollection
 */
class PhpCollectionTest extends MapperTestTemplate
{

    protected function createMapper()
    {
        return new PhpCollection($this->createMediatorMockup());
    }

    public function getDataFromDb()
    {
        $fixture = array('answer' => 42, 'word' => 'bazinga');
        $obj = new \ArrayObject($fixture);
        $dump[MapObject::FQCN_KEY] = 'ArrayObject';
        $dump[PhpCollection::CONTENT_KEY] = $fixture;

        $spl = new \SplObjectStorage();
        $key = new \tests\Alkahest\Fixtures\Simple();
        $spl[$key] = 123;
        $flat = [
            MapObject::FQCN_KEY => 'SplObjectStorage',
            PhpCollection::CONTENT_KEY => [
                PhpCollection::SPL_KEY => [
                    // not the full mapping, only the job of PhpCollection
                    // To map entirely the SplObjectStorage, we need a MapObject
                    $key
                ],
                PhpCollection::SPL_VALUE => [123]
            ]
        ];

        return [[$dump, $obj], [$flat, $spl]];
    }

    public function getDataToDb()
    {
        $fixture = array('answer' => 42, 'word' => 'bazinga');
        $obj = new \ArrayObject($fixture);
        $dump[MapObject::FQCN_KEY] = 'ArrayObject';
        $dump[PhpCollection::CONTENT_KEY] = $fixture;

        $spl = new \SplObjectStorage();
        $key = new \tests\Alkahest\Fixtures\Simple();
        $spl[$key] = 123;
        $flat = [
            MapObject::FQCN_KEY => 'SplObjectStorage',
            PhpCollection::CONTENT_KEY => [
                PhpCollection::SPL_KEY => [
                    // not the full mapping, only the job of PhpCollection
                    // To map entirely the SplObjectStorage, we need a MapObject
                    $key
                ],
                PhpCollection::SPL_VALUE => [123]
            ]
        ];

        return [[$obj, $dump], [$spl, $flat]];
    }

    public function getResponsibleDataToDb()
    {
        return [
            [new \ArrayObject()],
            [new \SplObjectStorage()]
        ];
    }

    public function getResponsibleDataFromDb()
    {
        return array(
            array(array(MapObject::FQCN_KEY => 'ArrayObject')),
            array(array(MapObject::FQCN_KEY => 'SplObjectStorage'))
        );
    }

    public function getNotResponsibleDataToDb()
    {
        return array(array(null), array(42), array(new \stdClass()), array(array('hello' => 42)));
    }

    public function getNotResponsibleDataFromDb()
    {
        return array(array(null), array(MapObject::FQCN_KEY => 'stdClass', 'prop' => 'hello'));
    }

}