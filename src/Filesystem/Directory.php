<?php

namespace h4kuna\DataType\Filesystem;

use Nette\DirectoryNotFoundException;

/**
 * @author Milan Matějček
 */
final class Directory
{

    private function __construct()
    {
        
    }

    /**
     * Remove all files in directory recusively.
     *
     * @param string $path
     */
    public static function removeRecursive($path)
    {
        
        foreach (new \DirectoryIterator($path) as $item) {
            if($item->isDot()) {
                continue;
            }
            $p = $item->getPathname();
            if ($item->isDir()) {
                self::removeRecursive($p);
                rmdir($p);
            } else {
                unlink($p);
            }
        }
    }

    public static function remove($path)
    {
        if (!is_dir($path) || rmdir($path)) {
            return TRUE;
        }

        // only message for exception
        if (count(@scandir($path)) - 2 == 0) {
            throw new DataTypeException('Directory "' . $path . '" can\'t delete because permision is not allowed.');
        }
        throw new DataTypeException('Directory "' . $path . '" can\'t delete because directory is not empty.');
    }

    /**
     * Mkdir recusivly.
     *
     * @param string $path
     * @param int $perm
     * @return bool
     */
    public static function mkdir($path, $perm = 0755)
    {
        $old = umask(0777 - $perm);
        mkdir($path, $perm, TRUE);
        umask($old);
    }

    public static function mkdirSafe($path, $perm = 0755)
    {
        if (!is_dir($path)) {
            self::mkdir($path, $perm);
        }
        return self::realPath($path);
    }

    /**
     * RealPath with Exception.
     *
     * @param string $path
     * @return string
     * @throws DirectoryNotFoundException
     */
    static public function realPath($path)
    {
        $_path = realpath($path);
        if (!$_path) {
            throw new DirectoryNotFoundException($path);
        }
        return $_path;
    }

}
