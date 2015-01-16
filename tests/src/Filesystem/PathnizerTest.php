<?php

namespace h4kuna\DataType\Filesystem;

class PathnizerTest extends \PHPUnit_Framework_TestCase
{

    public function testCreate()
    {
        $directory = self::getTemp('create') . '/foo/../bar/foo/';
        $dir = new Pathnizer($directory, Pathnizer::TYPE_DIR);
        $dirInfo = $dir->create();
        $this->assertTrue(is_dir($dirInfo->getPath()));

        $filePath = self::getTemp('create2') . '/foo/../bar/fooFile';
        $file = new Pathnizer($filePath, Pathnizer::TYPE_FILE);
        $fileInfo = $file->create();
        $this->assertTrue(is_file($fileInfo->getPathname()));
    }

    /**
     * @covers h4kuna\DataType\Filesystem\Pathnizer::getPath
     * @todo   Implement testGetPath().
     */
    public function testGetPath()
    {
        // non-exists path
        $file = new Pathnizer('/foo/bar/file', Pathnizer::TYPE_FILE);
        $this->assertSame('/foo/bar', (string) $file->getPath());

        $dir = new Pathnizer('/foo/bar/file', Pathnizer::TYPE_DIR);
        $this->assertSame('/foo/bar/file', (string) $dir->getPath());
    }

    /**
     * @covers h4kuna\DataType\Filesystem\Pathnizer::__toString
     * @todo   Implement test__toString().
     */
    public function test__toString()
    {
        $file = new Pathnizer('/foo/bar/file', Pathnizer::TYPE_FILE);
        $this->assertSame('/foo/bar/file', (string) $file);
    }

    private static function getTemp($path)
    {
        $base = __DIR__ . '/../../temp/' . $path;
        $baseReal = realpath($base);
        if ($baseReal) {
            Directory::removeRecursive($baseReal);
        }
        return $base;
    }

}
