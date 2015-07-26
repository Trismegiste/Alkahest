<?php

/*
 * Alkahest
 */

namespace Trismegiste\Alkahest\Transform\Mediator\Colleague;

use Trismegiste\Alkahest\Transform\Mediator\AbstractMapper;

/**
 * DateObject is a transformer \MongoDate <=> DateTime
 */
class DateObject extends AbstractMapper
{

    /**
     * {@inheritDoc}
     */
    public function mapFromDb($var)
    {
        $ret = new \DateTime();
        $ret->setTimestamp($var->sec);
        return $ret;
    }

    /**
     * {@inheritDoc}
     */
    public function mapToDb($obj)
    {
        if (get_class($obj) == 'MongoDate') {
            // since this mapper is not responsible for MongoDate mapping
            // this case never happen. Anyway, I prefer to check in case
            // of future regression
            throw new \LogicException('Cannot transform MongoDate because reversed will be a DateTime');
        }

        return new \MongoDate($obj->getTimestamp());
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleFromDb($var)
    {
        return (gettype($var) == 'object' ) && (get_class($var) == 'MongoDate');
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleToDb($var)
    {
        return (gettype($var) == 'object' ) && (get_class($var) == 'DateTime');
    }

}