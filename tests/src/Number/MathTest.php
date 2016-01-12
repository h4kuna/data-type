<?php

namespace h4kuna\DataType\Number;

class MathTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers h4kuna\Math::interval
     * @todo   Implement testInterval().
     */
    public function testInterval()
    {
        $this->assertSame(1, Math::interval(1, 2));
        $this->assertSame(1, Math::interval(1, 1));
        $this->assertSame(0, Math::interval(1, 0));

        $this->assertSame(2, Math::interval(2, 4, 1));
        $this->assertSame(2, Math::interval(2, 4, 2));
        $this->assertSame(3, Math::interval(2, 4, 3));

        $this->assertSame(-5, Math::interval(-5, -4, -6));

        $this->setExpectedException('h4kuna\DataType\InvalidArgumentsException');
        Math::interval(2, 1, 3);
    }

    /**
     * @covers h4kuna\Math::round5
     * @todo   Implement testRound().
     */
    public function testRound5()
    {
        $this->assertSame(1.0, Math::round5(1.0));
        $this->assertSame(1.0, Math::round5(1.1));
        $this->assertSame(1.0, Math::round5(1.24));
        $this->assertSame(1.5, Math::round5(1.25));
        $this->assertSame(1.5, Math::round5(1.3));
        $this->assertSame(1.5, Math::round5(1.4));
        $this->assertSame(1.5, Math::round5(1.5));
        $this->assertSame(1.5, Math::round5(1.6));
        $this->assertSame(1.5, Math::round5(1.74));
        $this->assertSame(2.0, Math::round5(1.75));
        $this->assertSame(2.0, Math::round5(1.8));
        $this->assertSame(2.0, Math::round5(1.9));
        $this->assertSame(2.0, Math::round5(2));

        $this->assertSame(-1.0, Math::round5(-1.0));
        $this->assertSame(-1.0, Math::round5(-1.1));
        $this->assertSame(-1.0, Math::round5(-1.24));
        $this->assertSame(-1.5, Math::round5(-1.25));
        $this->assertSame(-1.5, Math::round5(-1.3));
        $this->assertSame(-1.5, Math::round5(-1.4));
        $this->assertSame(-1.5, Math::round5(-1.5));
        $this->assertSame(-1.5, Math::round5(-1.6));
        $this->assertSame(-1.5, Math::round5(-1.74));
        $this->assertSame(-2.0, Math::round5(-1.75));
        $this->assertSame(-2.0, Math::round5(-1.8));
        $this->assertSame(-2.0, Math::round5(-1.9));
        $this->assertSame(-2.0, Math::round5(-2));
    }

    /**
     * @covers h4kuna\Math::safeDivision
     * @todo   Implement testSafeDivision().
     */
    public function testSafeDivision()
    {
        $this->assertSame(0, Math::safeDivision(0, 1));
        $this->assertSame(NULL, Math::safeDivision(1, 0));
        $this->assertSame(1, Math::safeDivision(1, 1));
    }

    /**
     * @covers h4kuna\Math::factorial
     * @todo   Implement testFactorial().
     */
    public function testFactorial()
    {
        $this->assertSame(120, Math::factorial(5));
        $this->setExpectedException('h4kuna\DataType\InvalidArgumentsException');
        Math::factorial(-1);
    }

}
