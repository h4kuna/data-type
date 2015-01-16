<?php

namespace h4kuna\DataType\Filesystem;

use Nette\Http\FileUpload;
use SplFileInfo;

/**
 * @author Milan Matějček
 */
class File
{

    /**
     * Save uploaded file.
     *
     * @param FileUpload $file
     * @param string $path
     * @return SplFileInfo
     */
    public static function save(FileUpload $file, $path)
    {
        if (!$file->isOk()) {
            return FALSE;
        }

        $pathName = self::prepareToSaveFile($file, $path);
        $file->move($pathName);
        return new SplFileInfo($pathName);
    }

    /**
     * 
     * @param string $path
     * @return boolean
     * @throws DataTypeException
     */
    public static function remove($path)
    {
        if (!is_file($path) || unlink($path)) {
            return TRUE;
        }
        throw new DataTypeException('File "' . $path . '" can\'t delete because permision is not allowed.');
    }

}
