<?php

namespace h4kuna;

/**
 * @author Milan Matějček
 */
final class Math
{

    private function __construct()
    {
        
    }

    /**
     * Allow number in interval and correct it.
     * 
     * @param $number
     * @param $max float
     * @param $min float
     * @return float
     */
    public static function interval($number, $max, $min = 0)
    {
        return max($min, min($max, $number));
    }

    /**
     * Zaokrouhlujici metoda na padesatniky
     * 
     * @param number $num
     * @param number $q
     * @param fce $fce
     * @return number
     */
    public static function round($num, $q = 5, $fce = 'ceil')
    {
        return $fce($num / $q) * $q;
    }

    /**
     * Returns least common multiple of two numbers
     *
     * @param a number 1
     * @param b number 2
     * @return lcm(a, b)
     */
    static function lcm($a, $b)
    {
        if ($a == 0 || $b == 0) {
            return 0;
        }
        return ($a * $b) / self::gcd($a, $b);
    }

    /**
     * Returns greatest common divisor of the given numbers
     *
     * @param a number 1
     * @param b number 2
     * @return gcd(a, b)
     */
    static function gcd($a, $b)
    {
        if ($a < 1 || $b < 1) {
            throw new RuntimeException("a or b is less than 1");
        }
        $remainder = 0;
        do {
            $remainder = $a % $b; //v tento okamzik v posledni iteraci plati ona podminka, ze zbytek == 0
            $a = $b; //ale kvuli dalsi pripadne iteraci posunujeme promenne
            $b = $remainder; //v b je proto 0, v a je gcd
        } while ($b != 0);
        return $a;
    }

    static function safeDivision($up, $down)
    {
        if (!$down) {
            return NULL;
        }
        return $up / $down;
    }

    /**
     * spocita faktorial
     * 
     * @param int $n
     * @return int
     */
    static function factorial($n)
    {
        if ($n == 0) {
            return 1;
        }
        if ($n < 0) {
            throw new LogicException("The number cann't negative number.");
        }
        return $n * self::factorial($n - 1);
    }

    /**
     * zjistuje, zda je cislo delitelne
     *
     * @param int|float $delenec
     * @param int|float $delitel
     * @return bool
     */
    static public function isDivision($delenec, $delitel)
    {
        return ($delenec % $delitel) === 0;
    }

}
