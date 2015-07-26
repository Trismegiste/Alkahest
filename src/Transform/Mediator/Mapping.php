<?php

/*
 * Alkahest
 */

namespace Trismegiste\Alkahest\Transform\Mediator;

/**
 * A contract for a mapper database <-> memory
 */
interface Mapping
{

    /**
     * Convert a variable to a persistable structure (typically an array)
     * It feels like serialization
     *
     * @param mixed $var
     *
     * @return mixed
     */
    function mapToDb($var);

    /**
     * Convert a variable coming from a persistance layer to its representation in memory
     * It feels like un-serialization
     *
     * @param mixed $var
     *
     * @return mixed
     */
    function mapFromDb($var);

    /**
     * Returns if this class is responsible for mapping a variable
     * coming from the DB
     *
     * @param mixed $var the variable to test
     * @return boolean
     */
    function isResponsibleFromDb($var);

    /**
     * Returns if this class is responsible for mapping a variable
     * going to the DB
     *
     * @param mixed $var the variable to test
     * @return boolean
     */
    function isResponsibleToDb($var);
}
