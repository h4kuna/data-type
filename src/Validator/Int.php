<?php

namespace h4kuna\DataType\Validator;

/**
 * @author Milan Matějček
 */
final class Int
{

    private function __construct()
    {
        
    }

    /**
     * 
     * @param string|int $value
     * @return int
     * @throws DataTypeException
     */
    public static function fromString($value)
    {
        if (is_int($value)) {
            return $value;
        }

        if (is_numeric($value) && $value == intval($value)) {
            return intval($value);
        }
        $out = preg_replace('~\W~', '', $value);
        $int = intval($out);
        if ($out != $int) {
            throw new DataTypeException('Input value is not integer. ' . $out);
        }

        return $int;
    }

}
