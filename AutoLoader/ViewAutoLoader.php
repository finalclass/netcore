<?php
/**

Copyright (C) Szymon Wygnanski (s@finalclass.net)

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
 */
namespace NetCore\AutoLoader;

use \NetCore\AutoLoader\AbstractAutoLoader;
use \NetCore\ViewCompiler;
use \NetCore\AutoLoader\Exception\NoViewCompilerSpecified;

/*require_once __DIR__ . '/AbstractAutoLoader.php';
require_once __DIR__ . '/../ViewCompiler/ViewCompiler.php';*/

/**
 * @author: Sel <s@finalclass.net>
 * @date: 30.03.12
 * @time: 10:55
 */
class ViewAutoLoader extends AbstractAutoLoader
{

	/** @var \NetCore\ViewCompiler */
	private $viewCompiler;

	public function autoload($className)
	{
		$classNameDirNotation = str_replace(array('\\', '_'), DIRECTORY_SEPARATOR, $className);
		foreach ($this->getIncludePaths() as $dir => $bool) {
			$noExtensionPath = $dir . DIRECTORY_SEPARATOR . $classNameDirNotation;
			$viewPath = $noExtensionPath . '.phtml';
			$compiledPath = $noExtensionPath . '.php';

			$lastViewModification = @filemtime($viewPath); //false is return if file does not exists
			$lastCompiledModification = @filemtime($compiledPath); //false is return if file does not exists

			if ($lastCompiledModification > $lastViewModification) {
				//here is hidden condition: this will only occure if compiled file exists
				require_once $compiledPath;
				return true;
			}

			if ($lastViewModification !== false) { //this means: if view file exists
				$this->compile($viewPath, $compiledPath);
				require_once $compiledPath;
				return true;
			}
		}
		return false;
	}

	/**
	 * @param \NetCore\ViewCompiler $value
	 * @return \NetCore\AutoLoader\ViewAutoLoader
	 */
	public function setViewCompiler(ViewCompiler $value)
	{
	    $this->viewCompiler = $value;
	    return $this;
	}

	/**
	 * @return \NetCore\ViewCompiler
	 */
	public function getViewCompiler()
	{
	    return $this->viewCompiler;
	}

	private function compile($inFilePath, $outFilePath)
	{
		$viewCompiler = $this->getViewCompiler();
		if(!$viewCompiler) {
			throw new NoViewCompilerSpecified('No view compiler specified!');
		}
		$viewClassContent = $viewCompiler->compileFile($inFilePath);
		$dir = dirname($outFilePath);
		@mkdir($dir);
		file_put_contents($outFilePath, $viewClassContent);
	}

}
