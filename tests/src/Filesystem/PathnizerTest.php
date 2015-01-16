<?php

namespace h4kuna\DataType\Filesystem;

class PathnizerTest extends \PHPUnit_Framework_TestCase
{

    public function testCreate()
    {
        $directory = self::getTemp() . '/create/foo/../';
        $dir = new Pathnizer($directory, Pathnizer::TYPE_DIR);
        $dirInfo = $dir->create();
        $this->assertSame(TRUE, is_dir($dirInfo->getPath()));
        $this->assertSame(self::getTemp() . '/create', realpath($dirInfo->getRealPath()));
    }

    /**
     * @covers h4kuna\DataType\Filesystem\Pathnizer::mkdir
     * @todo   Implement testMkdir().
     */
    public function testMkdir()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers h4kuna\DataType\Filesystem\Pathnizer::getPath
     * @todo   Implement testGetPath().
     */
    public function testGetPath()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers h4kuna\DataType\Filesystem\Pathnizer::createFileType
     * @todo   Implement testCreateFileType().
     */
    public function testCreateFileType()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers h4kuna\DataType\Filesystem\Pathnizer::isFile
     * @todo   Implement testIsFile().
     */
    public function testIsFile()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers h4kuna\DataType\Filesystem\Pathnizer::remove
     * @todo   Implement testRemove().
     */
    public function testRemove()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers h4kuna\DataType\Filesystem\Pathnizer::save
     * @todo   Implement testSave().
     */
    public function testSave()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers h4kuna\DataType\Filesystem\Pathnizer::__toString
     * @todo   Implement test__toString().
     */
    public function test__toString()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    private static function getTemp()
    {
        return __DIR__ . '/../../temp';
    }

}
