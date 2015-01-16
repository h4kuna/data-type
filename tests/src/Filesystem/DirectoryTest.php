<?php

namespace h4kuna\DataType\Filesystem;

class DirectoryTest extends \PHPUnit_Framework_TestCase
{

    public function testRemoveRecursive()
    {
        $dirRemove = self::getTemp('recursive');
        Directory::removeRecursive($dirRemove);
        $this->assertSame(FALSE, is_dir($dirRemove));

        $dirRemove = self::getTemp('recursiveStar');
        Directory::removeRecursive($dirRemove . '/*');
        $this->assertSame(TRUE, is_dir($dirRemove));
        rmdir($dirRemove);
    }

    public function testSlashes()
    {
        if (PHP_OS !== 'Linux') {
            $this->markTestIncomplete('This test is assest on linux platform.');
        }

        $this->assertSame('foo/bar', Directory::slashes('foo/bar'));
        $this->assertSame('foo/bar', Directory::slashes('foo\bar//////////'));
        $this->assertSame('/foo/bar', Directory::slashes('/foo/bar'));
        $this->assertSame('/foo/bar', Directory::slashes('/foo/bar/'));
        $this->assertSame('/foo/bar', Directory::slashes('/foo//bar'));
        $this->assertSame('/foo/bar', Directory::slashes('/foo\bar'));
        $this->assertSame('/foo/bar', Directory::slashes('/foo\bar\\'));
        $this->assertSame('/foo/foo/bar', Directory::slashes('/foo///////foo\\\\\\\\bar\\'));
        $this->assertSame('C:/foo/bar', Directory::slashes('C:\foo\bar\\'));
    }

    public function testRealpath()
    {
        $dir = realpath(self::getTemp('realpath'));
        $subDir = $dir . '/foo/../bar/..';
        $this->assertSame(FALSE, realpath($subDir));
        $this->assertSame($dir, Directory::realpath($dir));
    }

    private static function getTemp($path)
    {
        $dirRemove = __DIR__ . '/../../temp/' . $path;
        $dir = $dirRemove . '/foo/bar/foo';
        Directory::mkdir($dir);
        $file = dirname($dir) . '/testFile';
        touch($file);
        return $dirRemove;
    }

}
