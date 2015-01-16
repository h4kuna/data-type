<?php

namespace h4kuna\DataType\Filesystem;

use DirectoryIterator;
use h4kuna\DataType\DataTypeException;
use Nette\Http\FileUpload;
use Nette\Utils\Random;
use SplFileInfo;

/**
 *
 * @author Milan Matějček
 */
class Pathnizer
{

    const TYPE_DIR = 1;
    const TYPE_FILE = 2;

    /** @var string */
    private $path;

    /** @var string */
    private $type;

    public function __construct($path, $type = NULL)
    {
        if ($type === NULL) {
            if (is_dir($path)) {
                $type = self::TYPE_DIR;
            } elseif (is_file($path)) {
                $type = self::TYPE_FILE;
            } else {
                throw new DataTypeException('Type of filesistem is not defined, let\'s use constant ' . __CLASS__ . '::TYPE_*.');
            }
        }

        $this->path = rtrim(preg_replace('~(\\\|/)+~', DIRECTORY_SEPARATOR, $path), '\/');
        $this->type = $type;
    }

    /**
     * Create directory or empty file.
     * 
     * @param int $perm
     * @return SplFileInfo|DirectoryIterator
     */
    public function create($perm = 0755)
    {
        $this->mkdir($perm);
        if ($this->isFile()) {
            if (!touch($this->path)) {
                throw new DataTypeException('File "' . $this->path . '" can\'t delete because permision is not allowed.');
            }
            return new SplFileInfo($this->path);
        }
        return new DirectoryIterator($this->path);
    }

    /**
     * Create dir and return created path.
     * 
     * @param int $perm
     * @return string
     */
    public function mkdir($perm = 0755)
    {
        $dir = (string) $this->getPath();
        if (is_dir($dir)) {
            return $dir;
        }
        Directory::mkdir($dir, $perm);
        $realPath = Directory::realPath($dir);
        if ($this->isFile()) {
            $this->path = $realPath . DIRECTORY_SEPARATOR . basename($this->path);
        } else {
            $this->path = $realPath;
        }
        return $realPath;
    }

    /**
     * Directory path.
     * 
     * @return self 
     */
    public function getPath()
    {
        return new static($this->isFile() ? dirname($this->path) : $this->path, self::TYPE_DIR);
    }

    /**
     * @param string $name
     * @return self
     */
    public function createFileType($name)
    {
        return new static($this->getPath() . DIRECTORY_SEPARATOR . $name, self::TYPE_FILE);
    }

    /** @return bool */
    public function isFile()
    {
        return $this->type === self::TYPE_FILE;
    }

    public function remove($recursively = FALSE)
    {
        if ($this->isFile()) {
            File::remove($this->path);
        }

        if (!$recursively) {
            Directory::remove($this->path);
        }

        throw new \Nette\NotImplementedException('Recursive remove is not implmented.');
    }

    public function save(FileUpload $uplod, $name = NULL)
    {
        if ($name === NULL) {
            $name = $uplod->getSanitizedName();
            $file = $this->createFileType($name);
            $dir = $file->mkdir();
            $i = -1;
            do {
                ++$i;
                $pathName = $dir . $name;
                $name = Random::generate(5) . $name;
            } while (is_file($pathName));

            if ($i) {
                $file = $file->createFileType($name);
            }
        } elseif (is_callable($name)) {
            $file = $name($this->getPath());
        } else {
            $file = $this->createFileType($name);
        }

        $info = $file->create(); // lock place
        $uplod->move((string) $file);
        return $info;
    }

    public function __toString()
    {
        return $this->path;
    }

}
