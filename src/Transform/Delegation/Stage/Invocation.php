<?php

/*
 * Alkahest
 */

namespace Trismegiste\Alkahest\Transform\Delegation\Stage;

use Trismegiste\Alkahest\Transform\Mediator\Colleague;
use Trismegiste\Alkahest\Transform\Mediator\TypeRegistry;

/**
 * Design Pattern : Builder
 * Component : Builder (concrete) 
 * 
 * A builder to automagically store object in database by using the FQCN 
 * for class keys. Zero configuration needed.
 * Only magic for storing the type of object.
 * Warning : Can be very messy in queries
 * Usefull : when you have a model and don't want to alias each class. Also
 * usefull for other apps, you don't need to repeat the alias map, only the
 * model classes are needed.
 * Fail when a class not exists.
 */
class Invocation extends AbstractStage
{

    public function createObject(TypeRegistry $algo)
    {
        new Colleague\MapSkippable($algo);
        new Colleague\PhpCollection($algo);
        new Colleague\MapObject($algo);
    }

}