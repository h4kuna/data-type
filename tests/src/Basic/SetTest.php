<?php

namespace h4kuna\DataType\Basic;

class SetTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers h4kuna\DataType\Basic\Set::fromString
     * @todo   Implement testFromString().
     */
    public function testFromString()
    {
        $set = array('one' => TRUE, 'two' => TRUE, 'three' => TRUE, 'four' => TRUE, 'five' => TRUE);
        $setString = implode(',', array_keys($set));

        $this->assertSame($set, Set::fromString($setString));
        $this->assertSame($setString, Set::toString($set));

        $set['three'] = FALSE;
        $this->assertSame('one,two,four,five', Set::toString($set));
        unset($set['three']);
        $this->assertSame($set, Set::fromString('one,two,four,five'));
    }

}
