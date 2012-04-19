<?php

namespace NetCore;

/**
 * Author: Sel <s@finalclass.net>
 * Date: 11.11.11
 * Time: 13:38
 */
class AutoLoader
{

    static private $paths = array();

    static public function addIncludePath($path)
    {
        self::$paths[$path] = true;
    }

    static public function removeIncludePath($path)
    {
        unset(self::$paths[$path]);
    }

    static public function register()
    {
        \spl_autoload_register('\NetCore\Autoloader::autoload');
    }

    static public function unregister()
    {
        \spl_autoload_unregister('\NetCore\Autoloader::autoload');
    }

    static public function autoload($className)
    {
        foreach (self::$paths as $dir => $bool) {
            $filePath = $dir . DIRECTORY_SEPARATOR
                        . str_replace(array('\\', '_'), DIRECTORY_SEPARATOR, $className)
                        . '.php';

            if (file_exists($filePath)) {
                require_once $filePath;
                return true;
            }
        }
        return false;
    }

}
