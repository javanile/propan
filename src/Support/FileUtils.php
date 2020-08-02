<?php


namespace Javanile\Propan\Support;

/**
 * ProcessUtils is a bunch of utility methods.
 *
 * This class was originally copied from Symfony 3.
 */
class FileUtils
{
    /**
     * Escapes a string to be used as a shell argument.
     *
     * @param string $argument
     * @return string
     */
    public static function recursiveCopy($src,$dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while (($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    self::recursiveCopy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    /**
     *
     */
    public static function mkdir($pathname, $mode = 0777, $recursive = false)
    {
        if (is_dir($pathname)) {
            return;
        }

        mkdir($pathname, $mode, $recursive);
    }
}
