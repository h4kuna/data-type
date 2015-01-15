<?php

namespace h4kuna\DataType\Basic;

class IntTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers h4kuna\DataType\Basic\Int::fromString
     * @todo   Implement testFromString().
     */
    public function testFromString()
    {
        $this->assertSame(1, Int::fromString(1));
        $this->assertSame(1, Int::fromString('1.0'));
        $this->assertSame(1, Int::fromString('1'));
        $this->assertSame(1, Int::fromString(' 1 '));
        $this->assertSame(-1000, Int::fromString('- 1 000'));
        
        $this->setExpectedException('h4kuna\DataType\DataTypeException');
        $this->assertSame(1, Int::fromString('1.1')); // not int
    }

}
