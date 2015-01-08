<?php

namespace h4kuna\DataType;

use Iterator;

/**
 * 
 * 
 * @author Milan Matějček
 */
final class String
{

    private function __constructor()
    {
        
    }

    /**
     * 
     * @param string|int|float $value
     * @return float
     */
    public static function toFloat($value)
    {
        return Validator\Float::fromString($value);
    }

    /**
     * 
     * @param int|string $value
     * @return int
     */
    public static function toInt($value)
    {
        return Validator\Int::fromString($value);
    }

    /**
     * 
     * @param string $value
     * @return float[]
     */
    public static function toGps($value)
    {
        return Validator\Gps::fromString($value);
    }

    /**
     * 
     * @param array|Iterator|string $value
     * @return array
     */
    public function toSet($value)
    {
        return Validator\Set::fromString($value);
    }

}
