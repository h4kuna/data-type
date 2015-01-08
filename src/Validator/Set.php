<?php

namespace h4kuna\DataType\Validator;

use Iterator;

/**
 * Transform set from string to array and vice versa
 * MySQL data type SET to checkboxlist
 * 
 * @example
 * array(
 *  foo => TRUE,
 *  bar => TRUE,
 *  joe => FALSE
 * )
 * 
 * string: foo,bar
 * array: [foo => TRUE, bar => TRUE]
 * 
 * @author Milan Matějček
 */
final class Set
{

    private function __construct()
    {
        
    }

    /**
     * 
     * @param string|array|Iterator $value
     * @return array
     */
    public static function fromString($value)
    {
        if (is_string($value)) {
            return self::validateValue(explode(',', $value));
        }
        return self::getValidValue($value);
    }

    /**
     * 
     * @param string|array|Iterator $set
     * @return string
     */
    public function toString($set)
    {
        if (is_string($set)) {
            return $set;
        }

        return implode(',', self::getValidValue($set));
    }

    /**
     * 
     * @param array|Iterator $value
     * @return string[]
     */
    private static function getValidValue($value)
    {
        $out = array();
        foreach ($value as $k => $v) {
            if ($v) {
                $out[] = $k;
            }
        }
        return $out;
    }

    /**
     * 
     * @param string|array|Iterator $set
     * @return array
     */
    private static function validateValue($set)
    {
        return array_fill_keys($set, TRUE);
    }

}
