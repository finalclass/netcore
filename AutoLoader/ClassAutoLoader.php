<?php

namespace NetCore\AutoLoader;
use \NetCore\AutoLoader\AbstractAutoLoader;

require_once 'AbstractAutoLoader.php';

/**
 * Author: Sel <s@finalclass.net>
 * Date: 11.11.11
 * Time: 13:38
 */
class ClassAutoLoader extends AbstractAutoLoader
{

    public function autoload($className)
    {
	    $classNameDirNotation = str_replace(array('\\', '_'), DIRECTORY_SEPARATOR, $className);
	    $classNameExploded = explode(DIRECTORY_SEPARATOR, $classNameDirNotation);
	    $classNameLastPart = end($classNameExploded);
        foreach ($this->getIncludePaths() as $dir => $bool) {
	        $noExtensionPath = $dir . DIRECTORY_SEPARATOR . $classNameDirNotation;
            $filePath = $noExtensionPath . '.php';

            if (file_exists($filePath)) {
                require_once $filePath;
                return true;
            }

	        $longStyleFilePath = $noExtensionPath . DIRECTORY_SEPARATOR . $classNameLastPart . '.php';

	        if (file_exists($longStyleFilePath)) {
                require_once $longStyleFilePath;
                return true;
            }
        }
        return false;
    }

}
