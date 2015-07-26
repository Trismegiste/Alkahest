<?php

/*
 * Dokudokibundle
 */

namespace tests\Alkahest\Fixtures;

use Trismegiste\Alkahest\Persistence\Persistable;
use Trismegiste\Alkahest\Transform\Skippable;

/**
 * NonSense is ...
 *
 * @author flo
 */
class NonSense implements Persistable, Skippable
{

    public function getId()
    {
        
    }

    public function setId(\MongoId $od)
    {
        
    }

}