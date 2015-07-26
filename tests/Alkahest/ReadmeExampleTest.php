<?php

/*
 * Alkahest
 */

namespace tests\Alkahest {

    use Trismegiste\Alkahest\Transform\Delegation\Stage\Invocation;

    /**
     * ReadmeExample is an example for README.md
     */
    class ReadmeExampleTest extends \PHPUnit_Framework_TestCase
    {

        protected $invocation;
        protected $collection;

        protected function setUp()
        {
            $connector = new \tests\Alkahest\Persistence\ConnectorTest();
            $this->collection = $connector->testCollection();
            $facade = new \Trismegiste\Alkahest\Facade\Provider($this->collection);
            $this->invocation = $facade->createRepository(new Invocation());
        }

        public function testInvocationExample()
        {
            // simple object
            $doc = new \Some\Sample\Product('EF-85 L', 2000);
            // persisting
            $this->invocation->persist($doc);
            // restoring with invocation repository
            $restore = $this->invocation->findByPk((string) $doc->getId());
            $this->assertInstanceOf('Some\Sample\Product', $restore);
            // retrieving the content in the MongoDB
            $dump = $this->collection->findOne(array('_id' => $doc->getId()));
            $this->assertEquals('Some\Sample\Product', $dump['-fqcn']);
            $this->assertEquals('EF-85 L', $dump['title']);
            $this->assertEquals(2000, $dump['price']);
        }

    }

}

namespace Some\Sample {

    use \Trismegiste\Alkahest\Persistence\Persistable;

    class Product implements Persistable
    {

        use \Trismegiste\Alkahest\Persistence\PersistableImpl;

        protected $title;
        protected $price;

        public function __construct($title, $price)
        {
            $this->title = $title;
            $this->price = $price;
        }

    }

}