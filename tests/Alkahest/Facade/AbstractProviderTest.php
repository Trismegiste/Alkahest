<?php

namespace tests\Alkahest\Facade;

use Trismegiste\Alkahest\Facade\AbstractProvider;

/**
 * Test class for AbstractProvider.
 * Generated by PHPUnit on 2013-02-09 at 12:07:26.
 */
class AbstractProviderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AbstractProvider
     */
    protected $object;

    protected function setUp()
    {
        $collection = $this->getMockBuilder('MongoCollection')
                ->disableOriginalConstructor()
                ->getMock();

        $mediator = $this->getMock('Trismegiste\Alkahest\Transform\Mediator\AbstractMediator');
        $tranform = $this->getMock('Trismegiste\Alkahest\Transform\TransformerInterface');

        $director = $this->getMock('Trismegiste\Alkahest\Transform\Delegation\MappingDirector', array('create'));
        $director->expects($this->once())
                ->method('create')
                ->will($this->returnValue($mediator));

        $provider = $this->getMockForAbstractClass('Trismegiste\Alkahest\Facade\AbstractProvider', array($collection));
        $provider->expects($this->once())
                ->method('createDirector')
                ->will($this->returnValue($director));
        $provider->expects($this->once())
                ->method('createTransformer')
                ->will($this->returnValue($tranform));

        $this->object = $provider; 
        // ouch, it was hard. But I wanted to test all the process with mockup
        // it is also a good documentation to understand differnece between mediator
        // builder, director, transformer and repository
    }

    protected function tearDown()
    {
        unset($this->object);
    }

    public function testCreateRepository()
    {
        $builder = $this->getMockForAbstractClass('Trismegiste\Alkahest\Transform\Delegation\Stage\AbstractStage');
        $repo = $this->object->createRepository($builder);
        $this->assertInstanceOf('Trismegiste\Alkahest\Persistence\Repository', $repo);
    }

}
