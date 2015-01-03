<?php

namespace h4kuna\DataType\Scalar;

use h4kuna\DataType\DataType;

/**
 * @author Milan Matějček
 */
class String extends DataType
{

    protected function getEmptyValue()
    {
        return '';
    }

    protected function prepareValue($value)
    {
        $out = (string) $value;
        if ($this->getFlags() & self::TRIM) {
            return trim($out);
        }
        return $out;
    }

}
