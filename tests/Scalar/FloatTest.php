<?php

namespace h4kuna\Tests;

require_once __DIR__ . '/../bootstrap.php';

use h4kuna\DataType\Scalar\Float;
use PHPUnit_Framework_TestCase;

/**
 * @author Milan Matějček
 */
class FloatTest extends PHPUnit_Framework_TestCase
{

    public function testAccept()
    {
        $float = new Float;

        $this->assertSame(0.0, $float->getValue());
        $newFloat = $float->setValue(NULL);
        $this->assertNotSame($newFloat, $float);
        $this->assertSame(0.0, $newFloat->getValue());

        $this->assertSame(-1.0, $float->setValue(-1)->getValue());
        $this->assertSame(-1.0, $float->setValue('-1')->getValue());
        $this->assertSame(-1.0, $float->setValue('-1.0')->getValue());
        $this->assertSame(-1.0, $float->setValue('-1,0')->getValue());

        $this->assertSame(-1.1, $float->setValue(-1.1)->getValue());
        $this->assertSame(-1.1, $float->setValue('-1,1')->getValue());
        $this->assertSame(-1.1, $float->setValue('-1.1')->getValue());
        $this->assertSame(-1.1, $float->setValue('- 1 , 1')->getValue());

        $this->assertSame(-0.1, $float->setValue('- , 1')->getValue());

        $this->assertSame(1.0, $float->setValue('1')->getValue());
        $this->assertSame(1.0, $float->setValue('1 . 0')->getValue());
        $this->assertSame(1.0, $float->setValue('1 , 0')->getValue());
        $this->assertSame(1.0, $float->setValue('1 ')->getValue());
        $this->assertSame(1.0, $float->setValue('1 ,')->getValue());
        $this->assertSame(1.0, $float->setValue('1 .')->getValue());
        $this->assertSame(1.0, $float->setValue(1)->getValue());
        $this->assertSame(1.0, $float->setValue(1.0)->getValue());

        $this->assertSame(1.1, $float->setValue('1.1')->getValue());
        $this->assertSame(1.1, $float->setValue('1,1')->getValue());
    }

    public function testValueHour()
    {
        $float = new Float;
        $this->assertSame(0.0, $float->setValue('00:00:00')->getValue());
        $this->assertSame(0.0, $float->setValue('00:00')->getValue());
        $this->assertSame(1.5, $float->setValue('01:30')->getValue());
        $this->assertSame(1.5125, $float->setValue('01:30:45')->getValue());
    }

    public function testFlags()
    {
        $float = new Float;
        $float->setFlags($float::EMPTY_IS_NULL);
        $this->assertSame(NULL, $float->getValue());

        $float->setFlags($float::EMPTY_IS_NULL | $float::UNSIGNED);
        $this->assertSame(NULL, $float->getValue());

        // $float->setFlags($float::EMPTY_IS_NULL | $float::UNSIGNED);
        // $this->assertSame(-1, $float->getValue());
    }

    public function testReject()
    {
        
    }

}
