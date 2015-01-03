<?php

namespace h4kuna\DataType\Scalar;

use h4kuna\DataType\DataType;
use h4kuna\DataType\DataTypeException;

/**
 * @author Milan Matějček
 */
class Float extends DataType
{

    /**
     *
     * @param string|int|float $value
     * @return self
     */
    protected function prepareValue($value)
    {
        if ($value === NULL) {
            $out = $this->getEmptyValue();
        } elseif (is_float($value)) {
            $out = $value;
        } elseif (is_numeric($value)) {
            $out = floatval($value);
        } elseif (strstr($value, ':') !== FALSE) {
            $out = $this->getEmptyValue();
            foreach (explode(':', $value) as $i => $v) {
                $out += ($v / pow(60, $i));
            }
        } else {
            $out = $this->floatval(
                    preg_replace_callback('/(?:^-?)|([^\,\.\d]+|,)/', function ($found) {
                        if (!isset($found[1])) {
                            return $found[0];
                        }
                        if (isset($found[1]) && $found[1] === ',') {
                            return '.';
                        }
                        return '';
                    }, $value)
            );
        }

        if ($this->getFlags() & parent::UNSIGNED && $out < 0) {
            throw new DataTypeException('Input value is negative and it is not allowed.');
        }

        return $out;
    }

    /**
     * @see DataType
     * @return float
     */
    protected function getEmptyValue()
    {
        return 0.0;
    }

    private function floatval($value)
    {
        if (!is_numeric($value)) {
            throw new DataTypeException('This value is not float: ' . $value);
        }

        return floatval($value);
    }

}
