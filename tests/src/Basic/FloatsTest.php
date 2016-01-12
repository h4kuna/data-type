<?php

namespace h4kuna\DataType\Basic;

class FloatsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers h4kuna\DataType\Validator\Float::fromString
     * @todo   Implement testFromString().
     */
    public function testFromString()
    {
        $this->assertSame(0.0, Floats::fromString('0'));
        $this->assertSame(0.0, Floats::fromString('0.0'));
        $this->assertSame(0.0, Floats::fromString('-0.0'));
        $this->assertSame(0.0, Floats::fromString('-.0'));
        $this->assertSame(0.0, Floats::fromString('-0.'));

        $this->assertSame(-1.0, Floats::fromString(-1));
        $this->assertSame(-1.0, Floats::fromString(-1.0));
        $this->assertSame(-1.0, Floats::fromString('-1'));
        $this->assertSame(-1.0, Floats::fromString('-1.0'));
        $this->assertSame(-1.0, Floats::fromString('-1,0'));
        $this->assertSame(-1.0, Floats::fromString(' - 1 , 0 '));

        $this->assertSame(1.5, Floats::fromString('1:30'));
    }

    /**
     * @expectedException h4kuna\DataType\DataTypeException
     */
    public function testExceptionFloatNull()
    {
        Floats::fromString(NULL);
    }

    /**
     * @expectedException h4kuna\DataType\DataTypeException
     */
    public function testExceptionFloatChar()
    {
        $this->assertSame(-1.0, Floats::fromString('-1,d0'));
    }

    /**
     * @covers h4kuna\DataType\Validator\Float::fromHour
     * @todo   Implement testFromHour().
     */
    public function testFromHour()
    {
        $this->assertSame(0.0, Floats::fromHour('0:0:0'));
        $this->assertSame(1.5, Floats::fromHour('1:30'));
        $this->assertSame(1.5, Floats::fromHour('1:30:0'));
        $this->assertSame(1.5083, round(Floats::fromHour('1:30:30'), 4));
    }

}
