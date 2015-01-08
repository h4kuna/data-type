<?php

namespace h4kuna\DataType\Object;

/**
 * Immutable type
 *
 * @author Milan Matějček
 */
interface IType
{

    const EMPTY_IS_NULL = 1;
    const UNSIGNED = 2;
    const TRIM = 4;
    const AS_STRING = 8;

    /** @return self */
    public function setFlags($flag);

    /** @return int */
    public function getFlags();

    /** @return mixed */
    public function getValue();

    /** @see self::getValue() */
    public function setValue($value);

    /**
     * @param mixed $value
     * @return self new object
     */
    public function createValue($value);
}
