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
        if (is_int($value)) {
            $out = $value;
        } elseif (is_numeric($value) && $value == intval($value)) {
            $out = intval($value);
        } else {
            $out = preg_replace('~\W~', '', $value);
            if ($out != intval($out)) {
                throw new DataTypeException('Input value is not integer. ' . $out);
            }
        }

        if ($this->getFlags() & self::UNSIGNED && $out < 0) {
            throw new DataTypeException('Int is defined as unsigned. This is: ' . $out);
        }

        return $out;
    }

    /** @return int */
    protected function getEmptyValue()
    {
        return 0;
    }

}
