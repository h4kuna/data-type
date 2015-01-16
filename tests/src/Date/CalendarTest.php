<?php

namespace h4kuna\DataType\Date;

use DateTime;
use PHPUnit_Framework_TestCase;

class CalendarTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers h4kuna\DataType\Date\Calendar::getDays
     * @todo   Implement testGetDays().
     */
    public function testGetDays()
    {
        $this->assertSame(Calendar::getDays(), Calendar::getDays());
    }

    /**
     * @covers h4kuna\DataType\Date\Calendar::getMonths
     * @todo   Implement testGetMonths().
     */
    public function testGetMonths()
    {
        $this->assertSame(Calendar::getMonths(), Calendar::getMonths());
    }

    /**
     * @covers h4kuna\DataType\Date\Calendar::nameOfDay
     * @todo   Implement testNameOfDay().
     */
    public function testNameOfDay()
    {
        $days = Calendar::getDays();
        $today = (date('w') == 0 ? 7 : date('w'));
        $this->assertSame($days[$today], Calendar::nameOfDay());
        $this->assertSame($days[$today], Calendar::nameOfDay(date('w')));
        $this->assertSame($days[5], Calendar::nameOfDay(new DateTime('2016-12-30')));
        $this->setExpectedException('h4kuna\DataType\DataTypeException');
        Calendar::nameOfDay(8);
    }

    /**
     * @covers h4kuna\DataType\Date\Calendar::nameOfMonth
     * @todo   Implement testNameOfMonth().
     */
    public function testNameOfMonth()
    {
        $days = Calendar::getMonths();
        $today = date('n');
        $this->assertSame($days[$today], Calendar::nameOfMonth());
        $this->assertSame($days[$today], Calendar::nameOfMonth(date('n')));
        $this->assertSame($days[12], Calendar::nameOfMonth(new DateTime('2016-12-30')));
        $this->setExpectedException('h4kuna\DataType\DataTypeException');
        Calendar::nameOfMonth(13);
    }

    /**
     * @covers h4kuna\DataType\Date\Calendar::czechDate2Sql
     * @todo   Implement testCzechDate2Sql().
     */
    public function testCzechDate2Sql()
    {
        $format = 'Y-m-d';
        $dt = Calendar::czechDate2Sql('1.1.1986');
        $this->assertSame('1986-01-01', $dt->format($format));

        $dt = Calendar::czechDate2Sql('01.1.1986');
        $this->assertSame('1986-01-01', $dt->format($format));

        $dt = Calendar::czechDate2Sql('01.01.1986');
        $this->assertSame('1986-01-01', $dt->format($format));

        $dt = Calendar::czechDate2Sql('30.12.1986');
        $this->assertSame('1986-12-30', $dt->format($format));

        $format .= ' H:i:s';
        $dt = Calendar::czechDate2Sql('01.01.1986 01:01:01');
        $this->assertSame('1986-01-01 01:01:01', $dt->format($format));

        $dt = Calendar::czechDate2Sql('01.01.1986 1:1:1');
        $this->assertSame('1986-01-01 01:01:01', $dt->format($format));

        $dt = Calendar::czechDate2Sql('01.01.1986 1:01:01');
        $this->assertSame('1986-01-01 01:01:01', $dt->format($format));

        $dt = Calendar::czechDate2Sql('30.12.1986 23:59:59');
        $this->assertSame('1986-12-30 23:59:59', $dt->format($format));

        $dt = Calendar::czechDate2Sql('30.12.1986 23:59');
        $this->assertSame('1986-12-30 23:59:00', $dt->format($format));
    }

    /**
     * @covers h4kuna\DataType\Date\Calendar::februaryOfDay
     * @todo   Implement testFebruaryOfDay().
     */
    public function testFebruaryOfDay()
    {
        $years = array(2012 => 29, 2013 => 28, 2014 => 28, 2015 => 28, 2016 => 29);
        foreach ($years as $year => $days) {
            $this->assertSame($days, Calendar::februaryOfDay($year));
        }
    }

    /**
     * @covers h4kuna\DataType\Date\Calendar::easter
     * @todo   Implement testEaster().
     */
    public function testEaster()
    {
        $years = array(2012 => '2012-04-09', 2013 => '2013-04-01', 2014 => '2014-04-21', 2015 => '2015-04-06', 2016 => '2016-03-28');
        foreach ($years as $year => $days) {
            $this->assertSame($days, Calendar::easter($year)->format('Y-m-d'));
        }
    }

    /**
     * @covers h4kuna\DataType\Date\Calendar::getName
     * @todo   Implement testGetName().
     */
    public function testGetName()
    {
        $this->assertSame('Milan', Calendar::getName(new DateTime('2013-06-18')));
        $this->assertSame(Calendar::getName(), Calendar::getName(new DateTime));
    }

}
