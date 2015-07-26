<?php

/*
 * Alkahest
 */

namespace tests\Alkahest\Persistence;

use Trismegiste\Alkahest\Persistence\Connector;

/**
 * Description of ConnectorTest
 *
 * @author flo
 */
class ConnectorTest extends \PHPUnit_Framework_TestCase
{

    public function testCollection()
    {
        $server = (false !== getenv('SYMFONY__MONGODB__SERVER')) ? getenv('SYMFONY__MONGODB__SERVER') : 'localhost:27017';
        $param = array(
            'server' => $server,
            'database' => 'Alkahest',
            'collection' => 'TestSuite'
        );
        $cnx = new Connector($param);
        $coll = $cnx->getCollection();
        $this->assertInstanceOf('\MongoCollection', $coll);

        return $coll;
    }

}