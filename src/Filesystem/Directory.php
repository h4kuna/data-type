<?php

namespace h4kuna\DataType\Filesystem;

use FilesystemIterator;
use h4kuna\DataType\DataTypeException;
use h4kuna\DataType\DirectoryNotFoundException;

/**
 * @author Milan Matějček
 */
final class Directory
{

    private function __construct()
    {
        
    }

    /**
     * @example /foo/bar/* - Remove all files in directory recusively. Directory bar is not deleted.
     * @example /foo/bar - Remove all and bar directory.
     * 
     * @param string $path
     */
    public static function removeRecursive($path)
    {
        try {

            $removeRoot = TRUE;
            if (substr($path, -1) === '*') {
                $removeRoot = FALSE;
                $path = substr($path, 0, -1);
            }
            $path = self::realPath($path);
            self::recursiveRemove($path);
            if ($removeRoot) {
                rmdir($path);
            }
        } catch (DirectoryNotFoundException $e) {
            // path does not exists
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
     * Mkdir recusively.
     *
     * @param string $path
     * @param int $perm
     * @return string - Created path.
     */
    public static function mkdir($path, $perm = 0755)
    {
        $old = umask(0777 - $perm);
        mkdir($path, $perm, TRUE);
        umask($old);
    }

    /**
     * Check slashes.
     * 
     * @param type $path
     * @return type
     */
    public static function slashes($path)
    {
        return rtrim(preg_replace('~(\\\|/)+~', DIRECTORY_SEPARATOR, $path), '\/');
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
        $path = explode(DIRECTORY_SEPARATOR, self::slashes($path));
        $count = count($path);
        for ($i = 0; $i < $count; ++$i) {
            if ($path[$i] == '.') {
                unset($path[$i]);
            } elseif ($path[$i] == '..') {
                $j = $i - 1;
                while (!isset($path[$j])) {
                    --$j;
                }
                unset($path[$j], $path[$i]);
            }
        }
        $_path = implode(DIRECTORY_SEPARATOR, $path);
        if (!is_dir($_path)) {
            throw new DirectoryNotFoundException($_path);
        }
        return $_path;
    }

    private static function recursiveRemove($path)
    {
        foreach (new FilesystemIterator($path, FilesystemIterator::SKIP_DOTS) as $item) {
            $p = $item->getPathname();
            if ($item->isDir()) {
                self::recursiveRemove($p);
                rmdir($p);
            } else {
                unlink($p);
            }
        }
    }

}
