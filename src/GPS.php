<?php

namespace h4kuna\DataType;

/**
 * Transform GPS to lat/lng array
 * @author Milan Matějček
 */
class GPS  
{

    //Latitude [y] and Longitude [x]
    private static $xKey = 'x';
    private static $yKey = 'y';
    private static $round = 6;

    

    /**
     * global setup
     * @param int $round
     * @param string $xKey
     * @param string $yKey
     * @return self
     */
    public function setUp($round, $xKey, $yKey)
    {
        self::$round = $round;
        self::$xKey = $xKey;
        self::$yKey = $yKey;
        return $this;
    }

    

    /**
     * @param float $x
     * @param float $y
     */
    private function setCoordinate($x, $y)
    {
        $this->value = array(
            self::$xKey => round($x, self::$round),
            self::$yKey => round($y, self::$round)
        );
    }

    

    /**
     * @return string
     */
    public function getValue()
    {
        $v = parent::getValue();
        if ($this->getFlags() & self::AS_STRING) {
            return implode(',', array_reverse($v));
        }
        return $v;
    }

    

    protected function getEmptyValue()
    {
        return array();
    }

}
