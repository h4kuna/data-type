<?php

namespace h4kuna\DataType;

/**
 * Transform GPS to lat/lng array
 * @author Milan Matějček
 */
class GPS
{

    /** @var GpsSetup */
    private static $_setup;

    /** @var GpsSetup */
    private $setup;

    public function getSetup()
    {
        if ($this->setup === NULL) {
            $this->setup = self::getGlobalSetup();
        }
        return $this->setup;
    }

    public function setSetup(GpsSetup $setup)
    {
        $this->setup = $setup;
        return $this;
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

    public function setValue($value)
    {
        if (is_string($value)) {
            $gps = Validator\Gps::fromString($value);
        }
    }

    protected function getEmptyValue()
    {
        return array();
    }

    /** @return GpsSetup */
    private static function getGlobalSetup()
    {
        if (self::$_setup === NULL) {
            self::$_setup = new GpsSetup;
        }
        return self::$_setup;
    }

    public function __toString()
    {
        ;
    }

}

final class GpsSetup
{

    private $xName;
    private $yName;
    private $round;

    public function __construct($xName = 'x', $yName = 'y', $round = 6)
    {
        $this->xName = $xName;
        $this->yName = $yName;
        $this->round = Validator\Int::fromString($round);
    }

    public function getXName()
    {
        return $this->xName;
    }

    public function getYName()
    {
        return $this->yName;
    }

    public function getRound()
    {
        return $this->round;
    }

}
