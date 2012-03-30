<?php

namespace NetCore;
use \NetCore\AutoLoader\AbstractAutoLoader;

/**
 * Author: Sel <s@finalclass.net>
 * Date: 11.11.11
 * Time: 13:38
 */
class ClassAutoLoader extends AbstractAutoLoader
{

    public function autoload($className)
    {
        foreach (self::getIncludePaths() as $dir => $bool) {
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
