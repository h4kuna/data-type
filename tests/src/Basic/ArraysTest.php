<?php

namespace h4kuna\DataType\Basic;

class ArraysTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers h4kuna\DataType\Basic\Arrays::combine
     * @todo   Implement testCombine().
     */
    public function testCombine()
    {
        $this->assertSame(array(1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four'), Arrays::combine(array(1, 2, 3, 4), array('one', 'two', 'three', 'four')));

        $this->assertSame(array(1 => 'one', 2 => 'three', 3 => 'four', 4 => NULL), Arrays::combine(array(1, 2, 3, 4), array('one', 'three', 'four')));

        $this->assertSame(array(1 => 'one', 2 => 'three', 3 => 'four', 4 => 'five'), Arrays::combine(array(1, 2, 3, 4), array('one', 'three', 'four'), 'five'));

        $this->setExpectedException('h4kuna\DataType\InvalidArgumentsException');
        Arrays::combine(array(1, 2, 3, 4), array('one', 'two', 'three', 'four', 'five'));
    }

    /**
     * @covers h4kuna\DataType\Basic\Arrays::concatWs
     * @todo   Implement testConcatWs().
     */
    public function testConcatWs()
    {
        $array = array(1 => 0, 2 => NULL, 3 => 'three', 4 => FALSE, 5 => 'five', 6 => '', 7 => '0');
        $this->assertSame('0|three|five|0', Arrays::concatWs('|', $array));
        $this->assertSame('five', Arrays::concatWs('|', $array, 2, 4, 5, 6));
        $this->assertSame('three|five', Arrays::concatWs('|', $array, 2, 3, 4, 5, 6));
        $this->assertSame('five', Arrays::concatWs('|', $array, 2, 5, 5, 6));
    }

    /**
     * @covers h4kuna\DataType\Basic\Arrays::coalesce
     * @todo   Implement testCoalesce().
     */
    public function testCoalesce()
    {
        $this->assertSame('foo', Arrays::coalesce(array(NULL, FALSE, '', 'foo')));
        $this->assertSame('foo', Arrays::coalesce(array(NULL, FALSE, 'foo')));
        $this->assertSame('foo', Arrays::coalesce(array('foo', NULL, FALSE)));
        $this->assertSame('foo', Arrays::coalesce(array('bar', NULL, 'foo'), 1, 2));

        $this->assertSame(NULL, Arrays::coalesce(array(FALSE, NULL, '')));
        $this->assertSame(NULL, Arrays::coalesce(array()));
        $this->assertSame(NULL, Arrays::coalesce(array(), 1));
    }

    /**
     * @covers h4kuna\DataType\Basic\Arrays::kUnset
     * @todo   Implement testKUnset().
     */
    public function testKeysUnset()
    {
        $array = array(1 => 0, 2 => NULL, 3 => 'three', 4 => FALSE, 5 => 'five', 6 => '', 7 => '0');
        $newArray = Arrays::keysUnset($array, 1, 2);
        $this->assertSame(array(1 => 0, 2 => NULL), $newArray);
        $this->assertSame(array(3 => 'three', 4 => FALSE, 5 => 'five', 6 => '', 7 => '0'), $array);

        $newArray = Arrays::keysUnset($array, 'foo');
        $this->assertSame(array(), $newArray);

		$arrayObject = new \ArrayIterator(array(1 => 0, 2 => NULL, 3 => 'three', 4 => FALSE, 5 => 'five', 6 => '', 7 => '0'));
		$newArray = Arrays::keysUnset($arrayObject, 1, 2);
		$this->assertSame(array(1 => 0, 2 => NULL), $newArray);
		$this->assertSame(array(3 => 'three', 4 => FALSE, 5 => 'five', 6 => '', 7 => '0'), (array) $arrayObject);
    }

    /**
     * @covers h4kuna\DataType\Basic\Arrays::foo
     * @todo   Implement testFoo().
     */
    public function testIntesectKeys()
    {
        $array = array(1 => 0, 2 => NULL, 3 => 'three', 4 => FALSE, 5 => 'five', 6 => '', 7 => '0');
        $this->assertSame(array(2 => NULL, 3 => 'three', 5 => 'five'), Arrays::intesectKeys($array, array(2, 3, 5)));
    }

    /**
     * @covers h4kuna\DataType\Basic\Arrays::column
     * @todo   Implement testColumn().
     */
    public function testColumn()
    {
        $array = array(
            array('name' => 'Joe', 'id' => 1),
            array('name' => 'Doe', 'id' => 2),
            array('name' => 'Foo', 'id' => 3),
            array('name' => 'Bar', 'id' => 4)
        );
        $this->assertSame(array('Joe', 'Doe', 'Foo', 'Bar'), Arrays::column($array, 'name'));
        $this->assertSame(array(1 => 'Joe', 2 => 'Doe', 3 => 'Foo', 4 => 'Bar'), Arrays::column($array, 'name', 'id'));
        $this->assertSame(array(
            1 => array('name' => 'Joe', 'id' => 1),
            2 => array('name' => 'Doe', 'id' => 2),
            3 => array('name' => 'Foo', 'id' => 3),
            4 => array('name' => 'Bar', 'id' => 4)), Arrays::column($array, NULL, 'id'));

        $this->assertSame($array, Arrays::column($array));
    }

}
