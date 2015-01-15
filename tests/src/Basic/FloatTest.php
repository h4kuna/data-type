<?php

namespace h4kuna\DataType\Basic;

class FloatTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers h4kuna\DataType\Validator\Float::fromString
     * @todo   Implement testFromString().
     */
    public function testFromString()
    {
        $this->assertSame(0.0, Float::fromString('0'));
        $this->assertSame(0.0, Float::fromString('0.0'));
        $this->assertSame(0.0, Float::fromString('-0.0'));
        $this->assertSame(0.0, Float::fromString('-.0'));
        $this->assertSame(0.0, Float::fromString('-0.'));

        $this->assertSame(-1.0, Float::fromString(-1));
        $this->assertSame(-1.0, Float::fromString(-1.0));
        $this->assertSame(-1.0, Float::fromString('-1'));
        $this->assertSame(-1.0, Float::fromString('-1.0'));
        $this->assertSame(-1.0, Float::fromString('-1,0'));
        $this->assertSame(-1.0, Float::fromString(' - 1 , 0 '));
        
        $this->assertSame(1.5, Float::fromString('1:30'));
    }

    /**
     * @expectedException h4kuna\DataType\DataTypeException
     */
    public function testExceptionFloatNull()
    {
        Float::fromString(NULL);
    }

    /**
     * @expectedException h4kuna\DataType\DataTypeException
     */
    public function testExceptionFloatChar()
    {
        $this->assertSame(-1.0, Float::fromString('-1,d0'));
    }

    /**
     * @covers h4kuna\DataType\Validator\Float::fromHour
     * @todo   Implement testFromHour().
     */
    public function testFromHour()
    {
        $this->assertSame(0.0, Float::fromHour('0:0:0'));
        $this->assertSame(1.5, Float::fromHour('1:30'));
        $this->assertSame(1.5, Float::fromHour('1:30:0'));
        $this->assertSame(1.5083, round(Float::fromHour('1:30:30'), 4));
    }

}
