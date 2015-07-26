<?php

/*
 * Alkahest
 */

namespace tests\Alkahest\Transform\Delegation\Stage;

use Trismegiste\Alkahest\Transform\Delegation\Stage\Invocation;
use Trismegiste\Alkahest\Transform\Mediator\Colleague\MapObject;
use tests\Alkahest\Fixtures;
use Trismegiste\Alkahest\Transform\Mediator\Colleague\PhpCollection;

/**
 * test for Mediator created by Invocation builder
 */
class InvocationTest extends AbstractStageTest
{

    protected function createBuilder()
    {
        return new Invocation();
    }

    public function getSampleTree()
    {
        $obj = new \stdClass();
        $obj->answer = 42;
        $dump = array(MapObject::FQCN_KEY => 'stdClass', 'answer' => 42);

        $obj2 = new Fixtures\Cart("86 fdfg de fdf");
        $obj2->info = 'nothing to say';
        $obj2->addItem(3, new Fixtures\Product('EF85L', 1999));
        $obj2->addItem(1, new Fixtures\Product('Bike', 650));

        $fixture = 'tests\Alkahest\Fixtures';
        $dump2 = array(
            MapObject::FQCN_KEY => $fixture . '\Cart',
            'address' => '86 fdfg de fdf',
            'info' => 'nothing to say',
            'notInitialized' => null,
            'row' => array(
                0 => array(
                    'qt' => 3,
                    'item' => array(
                        MapObject::FQCN_KEY => $fixture . '\Product',
                        'title' => 'EF85L',
                        'price' => 1999
                    )
                ),
                1 => array(
                    'qt' => 1,
                    'item' => array(
                        MapObject::FQCN_KEY => $fixture . '\Product',
                        'title' => 'Bike',
                        'price' => 650,
                    )
                )
            )
        );

        return array(array($obj, $dump), array($obj2, $dump2));
    }

    public function getDataToDb()
    {
        $data = parent::getDataToDb();
        return array_merge($data, $this->getSampleTree());
    }

    public function getDataFromDb()
    {
        $data = parent::getDataFromDb();
        return array_merge($data, $this->getSampleTree());
    }

    public function testRestoreWithNonTrivialConstruct()
    {
        $obj = new Fixtures\VerifMethod(100);
        $dump = $this->mediator->recursivDesegregate($obj);
        $restore = $this->mediator->recursivCreate($dump);
        $this->assertInstanceOf('tests\Alkahest\Fixtures\VerifMethod', $restore);
        $this->assertEquals(119.6, $restore->getTotal());
    }

    /**
     * @expectedException \DomainException
     */
    public function testRootClassEmpty()
    {
        $obj = $this->mediator->recursivCreate(array(MapObject::FQCN_KEY => null, 'answer' => 42));
    }

    /**
     * @expectedException \DomainException
     */
    public function testLeafClassEmpty()
    {
        $obj = $this->mediator->recursivCreate(
                array(
                    MapObject::FQCN_KEY => 'stdClass',
                    'child' => array(MapObject::FQCN_KEY => null, 'answer' => 42)
                )
        );
    }

    /**
     * @expectedException \DomainException
     */
    public function testRootClassNotFound()
    {
        $this->mediator->recursivCreate(array(MapObject::FQCN_KEY => 'Snark', 'answer' => 42));
    }

    /**
     * @expectedException \DomainException
     */
    public function testLeafClassNotFound()
    {
        $obj = $this->mediator->recursivCreate(
                array(
                    MapObject::FQCN_KEY => 'stdClass',
                    'child' => array(MapObject::FQCN_KEY => 'Snark', 'answer' => 42)
                )
        );
    }

    public function testSkippable()
    {
        $obj = new Fixtures\IntoVoid();
        $dump = $this->mediator->recursivDesegregate($obj);
        $this->assertNull($dump);
    }

    public function testChildSkippable()
    {
        $obj = new \stdClass();
        $obj->dummy = new Fixtures\IntoVoid();
        $obj->product = new Fixtures\Product("aaa", 23);
        $dump = $this->mediator->recursivDesegregate($obj);
        $this->assertNull($dump['dummy']);
        $this->assertNotNull($dump['product']);
    }

    public function testCleanable()
    {
        $obj = new Fixtures\Bear();
        $dump = $this->mediator->recursivDesegregate($obj);
        $this->assertNull($dump['transient']);
        $this->assertEquals(42, $dump['answer']);
        $restore = $this->mediator->recursivCreate($dump);
        $this->assertEquals(range(1, 10), $restore->getTransient());
    }

    public function testSplObjectStorage()
    {
        $obj = new Fixtures\CartPlus();
        $obj->addItem(3, new Fixtures\Product('EF85L', 1999));
        $flat = [
            MapObject::FQCN_KEY => get_class($obj),
            'row' => [
                MapObject::FQCN_KEY => 'SplObjectStorage',
                PhpCollection::CONTENT_KEY => [
                    PhpCollection::SPL_KEY => [
                        [
                            MapObject::FQCN_KEY => 'tests\Alkahest\Fixtures\Product',
                            'title' => 'EF85L',
                            'price' => 1999
                        ]
                    ],
                    PhpCollection::SPL_VALUE => [3]
                ]
            ]
        ];

        $dump = $this->mediator->recursivDesegregate($obj);
        $this->assertEquals($flat, $dump);
        $restore = $this->mediator->recursivCreate($dump);

        // SplObjectStorage are not equals since spl_object_hash($obj)
        // are unique for each Product instances        
        $this->assertEquals($obj->getIterator()->current(), $restore->getIterator()->current());
        $this->assertEquals($obj->getIterator()->getInfo(), $restore->getIterator()->getInfo());
    }

    public function testArrayObject()
    {
        $obj = new Fixtures\AOPersistable([new Fixtures\Product('lightsaber', 20000)]);
        $dump = $this->mediator->recursivDesegregate($obj);
        $restore = $this->mediator->recursivCreate($dump);

        $this->assertEquals($obj->getCollection()->getArrayCopy(), $restore->getCollection()->getArrayCopy());
    }

}
