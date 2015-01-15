<?php

namespace h4kuna\DataType\Basic;

class StringTest extends \PHPUnit_Framework_TestCase
{

    public function testToFloat()
    {
        $this->assertSame(1.1, String::toFloat('1.1'));
    }

    public function testToInt()
    {
        $this->assertSame(1, String::toInt('1'));
    }

    public function testToGps()
    {
        $coordinate = String::toGps('51.1, 14.1');
        array_walk($coordinate, function(&$v) {
            $v = (string) round($v, 1);
        });
        $this->assertSame(array('51.1', '14.1'), $coordinate);
    }

    public function testToSet()
    {
        $this->assertSame(array('foo' => TRUE, 'bar' => TRUE), String::toSet('foo,bar'));
    }

    public function testAutoUTF()
    {
        $str = 'Příliš žluťoučký kůň úpěl ďábelské ódy.';
        iconv('UTF-8', 'ISO-8859-1', $str);
    }

}
