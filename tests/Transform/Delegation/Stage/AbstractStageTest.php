<?php

/*
 * Alkahest
 */

namespace tests\Alkahest\Transform\Delegation\Stage;

use Trismegiste\Alkahest\Transform\Delegation\MappingDirector;

/**
 * Template test for Mediator created by a builder
 *
 * @author flo
 */
abstract class AbstractStageTest extends \PHPUnit\Framework\TestCase {

    protected $mediator;

    protected function setUp(): void {
        $director = new MappingDirector();
        $bluePrint = $this->createBuilder();
        $this->mediator = $director->create($bluePrint);
    }

    protected function tearDown(): void {
        unset($this->mediator);
    }

    abstract protected function createBuilder();

    public function testMediator() {
        $this->assertInstanceOf('Trismegiste\Alkahest\Transform\Mediator\Mediator', $this->mediator);
    }

    protected function getSymetricData() {
        $sample = array(null, 42, 3.141592, true, 'tribble', array('Ar' => 6));
        $sample[] = array('root' => array('trunk' => array('branch' => array('leaf'))));
        $compare = array();
        foreach ($sample as $val) {
            $compare[] = array($val, $val);
        }

        return $compare;
    }

    /**
     * A list of couple ( memory representation , database representation )
     */
    public function getDataFromDb() {
        $compare = $this->getSymetricData();
        return $compare;
    }

    public function getDataToDb() {
        $compare = $this->getSymetricData();
        $compare[] = array(fopen(__FILE__, 'r'), null);
        return $compare;
    }

    /**
     * @dataProvider getDataToDb
     */
    public function testDesegregateCommon($obj, $db) {
        $dump = $this->mediator->recursivDesegregate($obj);
        $this->assertEquals($db, $dump);
    }

    /**
     * @dataProvider getDataFromDb
     */
    public function testCreateCommon($obj, $db) {
        $dump = $this->mediator->recursivCreate($db);
        $this->assertEquals($obj, $dump);
    }

}
