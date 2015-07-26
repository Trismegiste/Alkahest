<?php

/*
 * Alkahest
 */

namespace Trismegiste\Alkahest\Transform\Mediator\Colleague;

use Trismegiste\Alkahest\Transform\Mediator\AbstractMapper;
use Trismegiste\Alkahest\Transform\Mediator\Colleague\MapObject;

/**
 * PhpCollection maps php collections internal classes
 * like ArrayObject and SplObjecStorage
 */
class PhpCollection extends AbstractMapper
{

    const CONTENT_KEY = 'content';
    const SPL_KEY = 'key';
    const SPL_VALUE = 'value';

    protected $collectionType = array('ArrayObject', 'SplObjectStorage');

    /**
     * {@inheritDoc}
     */
    public function isResponsibleFromDb($var)
    {
        return is_array($var) &&
                array_key_exists(MapObject::FQCN_KEY, $var) &&
                in_array($var[MapObject::FQCN_KEY], $this->collectionType);
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleToDb($var)
    {
        return is_object($var) && in_array(get_class($var), $this->collectionType);
    }

    /**
     * {@inheritDoc}
     */
    public function mapFromDb($var)
    {
        $collection = null;

        switch ($var[MapObject::FQCN_KEY]) {
            case 'ArrayObject':
                $collection = new \ArrayObject();
                foreach ($var[self::CONTENT_KEY] as $key => $val) {
                    $collection[$key] = $this->mediator->recursivCreate($val);
                }
                break;

            case 'SplObjectStorage' :
                $collection = new \SplObjectStorage();
                foreach ($var[self::CONTENT_KEY][self::SPL_KEY] as $idx => $key) {
                    $val = $this->mediator->recursivCreate($var[self::CONTENT_KEY][self::SPL_VALUE][$idx]);
                    $objKey = $this->mediator->recursivCreate($key);
                    $collection[$objKey] = $val;
                }
                break;
        }

        return $collection;
    }

    /**
     * {@inheritDoc}
     */
    public function mapToDb($var)
    {
        $struc[MapObject::FQCN_KEY] = get_class($var);

        switch (get_class($var)) {
            case 'ArrayObject':
                $struc[self::CONTENT_KEY] = $this->dumpArray($var);
                break;

            case 'SplObjectStorage' :
                $struc[self::CONTENT_KEY] = $this->dumpSplStorage($var);
                break;
        }

        return $struc;
    }

    protected function dumpArray(\ArrayObject $arr)
    {
        $content = array();

        foreach ($arr as $key => $val) {
            $content[$key] = $this->mediator->recursivDesegregate($val);
        }

        return $content;
    }

    protected function dumpSplStorage(\SplObjectStorage $arr)
    {
        $contentKey = array();
        $contentVal = array();

        foreach ($arr as $idx => $val) {
            $contentKey[$idx] = $this->mediator->recursivDesegregate($val);
            $contentVal[$idx] = $this->mediator->recursivDesegregate($arr->getInfo());
        }

        return array(self::SPL_KEY => $contentKey, self::SPL_VALUE => $contentVal);
    }

}