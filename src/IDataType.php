<?php

namespace h4kuna\DataType;

/**
 * Immutable type
 *
 * @author Milan Matějček
 */
interface IDataType
{

    const EMPTY_IS_NULL = 1;
    const UNSIGNED = 2;
    const TRIM = 4;
    const AS_STRING = 8;

    /** @return self */
    public function setFlags($flag);

    public function getValue();

    /** @return self new object */
    public function setValue($value);
}
