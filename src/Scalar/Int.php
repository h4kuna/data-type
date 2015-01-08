<?php

namespace h4kuna\DataType\Scalar;

use h4kuna\DataType\DataType;
use h4kuna\DataType\DataTypeException;

/**
 * Base type integer as object
 *
 * @author Milan Matějček
 */
class Int extends DataType
{

    /**
     * @param string|int $value
     * @return self
     */
    protected function prepareValue($value)
    {
        
    }

    /** @return int */
    protected function getEmptyValue()
    {
        return 0;
    }

}
