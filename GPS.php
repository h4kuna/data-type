<?php

namespace h4kuna;

use Nette\Object;

/**
 * transform GPS to lat/lng array
 * @author Milan Matějček
 */
class GPS extends Object {

    //Latitude [y] and Longitude [x]
    private $coordinate = array();
    private static $xKey = 'x';
    private static $yKey = 'y';
    private static $round = 6;

    public function setUp($round, $xKey, $yKey) {
        self::$round = $round;
        self::$xKey = $xKey;
        self::$yKey = $yKey;
        return $this;
    }

    public function match($gps) {
        $found = array();
        if (preg_match('~^(\d{1,3}\.\d*?)(N|S), ?(\d{1,3}\.\d*?)(E|W)$~i', $gps, $found)) {
            //'50.4113628N, 14.9032000E
            $this->setCoordinate(self::checkCoordinate($found[3], $found[4]), self::checkCoordinate($found[1], $found[2]));
        } elseif (preg_match('~(-?\d{1,3}\.\d*), ?(-?\d{1,3}\.\d*)$~', $gps, $found)) {
            //'50.4113628, 14.9032000'
            $this->setCoordinate($found[2], $found[1]);
        } elseif (preg_match('~^(N|S) ?(\d{1,3})°(\d{1,2}\.\d*?)\', ?(W|E) ?(\d{1,3})°(\d{1,2}\.\d*?)\'$~i', $gps, $found)) {
            //N 50°24.68177', E 14°54.19200'
            $this->setCoordinate(self::checkCoordinate(self::degToDec($found[5], $found[6]), $found[4]), self::checkCoordinate(self::degToDec($found[2], $found[3]), $found[1]));
        } elseif (preg_match('~^(\d{1,3})°(\d{1,2})\'(\d{1,2}\.\d*?)"(N|S), ?(\d{1,3})°(\d{1,2})\'(\d{1,2}\.\d*?)"(W|E)$~i', $gps, $found)) {
            //50°24'40.906"N, 14°54'11.520"E
            $this->setCoordinate(self::checkCoordinate(self::degToDec($found[5], $found[6], $found[7]), $found[8]), self::checkCoordinate(self::degToDec($found[1], $found[2], $found[3]), $found[4]));
        } else {
            throw new GPSException('Unsupported coordinate. ' . $gps);
        }
        return $this->coordinate;
    }

    public function getCoordinate() {
        return $this->coordinate;
    }

    private function setCoordinate($x, $y) {
        $this->coordinate = array(
            self::$xKey => round($x, self::$round),
            self::$yKey => round($y, self::$round)
        );
    }

    private static function checkCoordinate($num, $pole) {
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
                throw new GPSException('Unsupported pole ' . $pole);
        }

        if ($num > 180) {
            throw new GPSException('Coordinate can be higher then 180 ' . $num);
        }

        return $num;
    }

    public static function degToDec($degrees, $minutes, $seconds = 0) {
        return $degrees + $minutes / 60 + $seconds / 3600;
    }

}

class GPSException extends \RuntimeException {

}