<?php

/*
 * Yuurei
 */

namespace Trismegiste\Alkahest\Transform\Mediator\Colleague;

use Trismegiste\Alkahest\Transform\Mediator\AbstractMapper;
use Trismegiste\Alkahest\Transform\Mediator\TypeRegistry;

/**
 * InvariantObject is a identity mapper for object
 */
class InvariantObject extends AbstractMapper {

    protected $invariant;

    public function __construct(TypeRegistry $ctx, array $fqcn) {
        parent::__construct($ctx);
        $this->invariant = $fqcn;
    }

    /**
     * {@inheritDoc}
     */
    public function mapFromDb($var) {
        return $var;
    }

    /**
     * {@inheritDoc}
     */
    public function mapToDb($obj) {
        return $obj;
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleFromDb($var): bool {
        return (gettype($var) == 'object' ) &&
                in_array(get_class($var), $this->invariant);
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleToDb($var): bool {
        return $this->isResponsibleFromDb($var);
    }

}
