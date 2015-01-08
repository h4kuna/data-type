<?php

namespace h4kuna\DataType\Validator;

/**
 * @author Milan Matějček
 */
final class Gps
{

    private function __construct()
    {
        
    }

    /**
     * 
     * @param string $value
     * @return float[]
     * @throws DataTypeException
     */
    public static function fromString($value)
    {
        $found = array();
        if (preg_match('~^(\d{1,3}\.\d+?)(N|S), ?(\d{1,3}\.\d+?)(E|W)$~i', $value, $found)) {
            //50.4113628N, 14.9032000E
            $this->setCoordinate(self::checkCoordinate($found[3], $found[4]), self::checkCoordinate($found[1], $found[2]));
        } elseif (preg_match('~(-?\d{1,3}\.\d+), ?(-?\d{1,3}\.\d+)$~', $value, $found)) {
            //50.4113628, 14.9032000
            $this->setCoordinate($found[2], $found[1]);
        } elseif (preg_match('~^(N|S) ?(\d{1,3})°(\d{1,2}\.\d+?)\',? ?(W|E) ?(\d{1,3})°(\d{1,2}\.\d+?)\'$~i', $value, $found)) {
            //N 50°24.68177', E 14°54.19200'
            $this->setCoordinate(self::checkCoordinate(self::degToDec($found[5], $found[6]), $found[4]), self::checkCoordinate(self::degToDec($found[2], $found[3]), $found[1]));
        } elseif (preg_match('~^(\d{1,3})°(\d{1,2})\'(\d{1,2}\.\d+?)"(N|S), ?(\d{1,3})°(\d{1,2})\'(\d{1,2}\.\d+?)"(W|E)$~i', $value, $found)) {
            //50°24'40.906"N, 14°54'11.520"E
            $this->setCoordinate(self::checkCoordinate(self::degToDec($found[5], $found[6], $found[7]), $found[8]), self::checkCoordinate(self::degToDec($found[1], $found[2], $found[3]), $found[4]));
        } elseif (preg_match('~^(N|S)(\d{1,3}\.\d+?)° ?(E|W)(\d{1,3}\.\d+?)°$~i', $value, $found)) {
            //N49.20811° E19.04247°
            $this->setCoordinate(self::checkCoordinate($found[4], $found[3]), self::checkCoordinate($found[2], $found[1]));
        } else {
            throw new DataTypeException('Unsupported coordinate. ' . $value);
        }
        return $this;
    }

    /**
     * Transform coordinate
     *
     * @param float $num
     * @param string $pole
     * @return float
     * @throws DataTypeException
     */
    private static function checkCoordinate($num, $pole)
    {
        switch (strtoupper($pole)) {
            case 'W':
            case 'S':
                if ($num > 0) {
                    $num *= -1;
                }
                break;
            case 'E':
            case 'N':
                if ($num < 0) {
                    $num *= -1;
                }
                break;
            default :
                throw new DataTypeException('Unsupported pole ' . $pole);
        }

        if ($num > 180) {
            throw new DataTypeException('Coordinate can be higher then 180 ' . $num);
        }

        return $num;
    }

    /**
     * Transform to float
     * 
     * @param float $degrees
     * @param float $minutes
     * @param float $seconds
     * @return float
     */
    public static function degToDec($degrees, $minutes, $seconds = 0)
    {
        return $degrees + $minutes / 60 + $seconds / 3600;
    }

}
