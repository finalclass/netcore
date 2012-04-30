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

namespace NetCore;

use \NetCore\Utils\ArrayUtils;
use \NetCore\Loader\Exception\NotAllowed;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 31.01.12
 * @time: 21:24
 */
class Loader
{

    /**
     * Example content:
     * array(
    '/Loader/Front/Layout' => array(
    'allowed' => array('admin'),
    'options' => array('header' => 'Hahaha', 'title' => 'super')
    ),
    '/Loader/Front' => array(
    'allowed' => array('moderator'),
    'options' => array('title' => 'test')
    )
    );
     *
     * @var array
     */
    private $params = array();

    static private $mimeTypes = array(
        'pdf' => 'application/pdf',
        'exe' => 'application/octet-stream',
        'zip' => 'application/zip',
        'doc' => 'application/msword',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',
        'gif' => 'image/gif',
        'png' => 'image/png',
        'jpeg' => 'image/jpg',
        'jpg' => 'image/jpeg',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'ttf' => 'application/octet-stream',
        'otf' => 'application/octet-stream',
        'eot' => 'application/vnd.ms-fontobject',
        'html' => 'text/html',
        'htm' => 'text/html',
        'swf' => 'application/x-shockwave-flash',
    );

    static private $staticResourceTypes = array(
        'pdf', 'exe', 'zip', 'doc', 'xls',
        'ppt', 'gif', 'png', 'jpeg', 'jpg',
        'css', 'js', 'ttf', 'eot', 'otf',
        'html', 'htm', 'swf'
    );

    private $roles = array();

    private $dir = '';

    /**
     * Relative to $dir
     *
     * @var array
     */
    private $currentPathExploded = array();

    public function __construct($options = array())
    {
        $this->setOptions($options);
    }

    public function setOptions($options = array())
    {
        if (is_string($options)) {
            $options = array('dir' => $options);
        }
        if (isset($options['params']) && is_array($options['params'])) {
            foreach ($options['params'] as $namespace => $params) {
                $this->find('/' . $namespace);
                if (isset($params['allowed'])) {
                    $this->setAllowed($params['allowed']);
                }
                if (isset($params['options'])) {
                    $this->addOptions($params['options']);
                }
            }
        }
        if (isset($options['dir'])) {
            $this->dir = $options['dir'];
        }
        if (isset($options['roles'])) {
            $this->roles = is_string($options['roles'])
                    ? array($options['roles']) : $options['roles'];
        }
        return $this;
    }

    /**
     * @param string $value
     * @return \NetCore\Loader
     */
    public function setRoles($value)
    {
        $this->roles = is_array($value) ? $value : array($value);
        return $this;
    }

    /**
     * @return string
     */
    public function getRoles()
    {
        return empty($this->roles) ? array() : $this->roles;
    }

    /**
     * @param string $value
     * @return \NetCore\Loader
     */
    public function setDir($value)
    {
        $this->dir = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getDir()
    {
        return empty($this->dir) ? '' : $this->dir;
    }

    public function find($path)
    {
        if(is_string($path)) {
            $questionMarkPos = strpos($path, '?');
            if($questionMarkPos !== false) {
                $path = substr($path, 0, $questionMarkPos);
            }
        }

        if (is_object($path)) {
            $path = '/' . get_class($path);
        }
        $pathExploded = explode('/', str_replace(array('\\', '/'), '/', $path));
        $fullPath = current($pathExploded) == ''
                ? $pathExploded : array_merge($this->currentPathExploded, $pathExploded);
        $resolvedPath = array();
        foreach ($fullPath as $path) {
            if ($path == '..') {
                array_pop($resolvedPath);
                continue;
            } else if (empty($path)) {
                continue;
            }
            $resolvedPath[] = $path;
        }
        $this->currentPathExploded = $resolvedPath;
        return $this;
    }

    public function __toString()
    {
        return $this->isStaticResource()
                ? (string)$this->getPath() : (string)$this->getFullPath();
    }

    /**
     * @param string $value
     * @return \NetCore\Loader
     */
    public function setAllowed($value)
    {
        if (!is_array($value)) {
            $value = array($value);
        }
        $namespace = $this->getPath();
        if (!isset($this->params[$namespace])) {
            $this->params[$namespace] = array();
        }
        $this->params[$namespace]['allowed'] = array_filter($value);
        return $this;
    }

    public function addOptions($options)
    {
        $namespace = $this->getPath();
        if (!isset($this->params[$namespace])) {
            $this->params[$namespace] = array();
        }

        if (!isset($this->params[$namespace]['options'])) {
            $this->params[$namespace]['options'] = array();
        }
        $this->params[$namespace]['options'] =
                ArrayUtils::arrayMergeRecursiveSimple(
                    $this->params[$namespace]['options'], $options
                );
        return $this;
    }

    public function exists()
    {
        return file_exists($this->dir . '/' . $this->getPath());
    }

    public function getPath()
    {
        return '/' . join('/', $this->currentPathExploded);
    }

    public function getFileContents()
    {
        return file_get_contents($this->getFullPath());
    }

    public function getFullPath()
    {
        $path = str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, $this->dir . $this->getPath());
        $path = realpath($path);
        return $path;
    }

    public function config()
    {
        $options = array();
        $allowed = array();

        foreach ($this->params as $namespace => $params) {
            $currentPath = $this->getPath();

            if (strpos($currentPath, $namespace) === 0) {
                $len = strlen($namespace);
                $params = array_merge_recursive(array('options' => array(), 'allowed' => array()), $params);
                $allowed[$len] = isset($allowed[$len]['allowed'])
                        ? array_merge($allowed[$len]['allowed'], $params['allowed']) : $params['allowed'];
                $options[$len] = isset($configs[$len]['options'])
                        ? array_merge($configs[$len], $params['options']) : $params['options'];
            }
        }

        ksort($options);
        ksort($allowed);

        $totalOptions = array();
        foreach ($options as $cfg) {
            $totalOptions = ArrayUtils::arrayMergeRecursiveSimple($totalOptions, $cfg);
        }
        return array('options' => $totalOptions, 'allowed' => end($allowed));
    }

    static public function loadClass($dir, $className)
    {
        $dir = $dir . str_replace(array('/', '\\', '_'), '/', $className);
        $dirExploded = explode('/', $dir);
        $filePath = $dir . '/' . end($dirExploded) . '.php';
        $oldStyleFilePath = join(DIRECTORY_SEPARATOR, $dirExploded) . '.php';
        if (file_exists($filePath)) {
            require_once $filePath;
            return true;
        } else if (file_exists($oldStyleFilePath)) {
            require_once  $oldStyleFilePath;
            return true;
        } else {
            return false;
        }
    }

    public function registerAutoloader()
    {
        $dir = $this->getDir();
        spl_autoload_register(function($className) use($dir)
        {
            return Loader::loadClass($dir, $className);
        });
    }

    public function create()
    {
        $config = $this->config();
        if (!$this->isAnyRoleAllowed($config['allowed'])) {
            throw new NotAllowed();
        }
        $className = '\\' . join('\\', $this->currentPathExploded);
        self::loadClass($this->getDir(), $className);
        return new $className($config['options']);
    }

    private function isAnyRoleAllowed($allowedRoles)
    {
        if (!is_array($allowedRoles)) {
            return true;
        }
        foreach ($allowedRoles as $allowed) {
            foreach ($this->roles as $role) {
                if ($role == $allowed) {
                    return true;
                }
            }
        }
        return empty($allowedRoles);
    }

    public function isAllowed()
    {
        $config = $this->config();
        return $this->isAnyRoleAllowed($config['allowed']);
    }

    private function getContentTypeByExtension()
    {
        $ext = $this->getExtension();
        // Determine Content Type
        return isset(self::$mimeTypes[$ext])
                ? self::$mimeTypes[$ext] : 'application/force-download';
    }

    private function getExtension()
    {
        $pathParts = pathinfo($this->getFullPath());
        return empty($pathParts['extension']) ? '' : strtolower($pathParts['extension']);
    }

    public function isStaticResource()
    {
        return array_search($this->getExtension(), self::$staticResourceTypes) !== false;
    }


    public function sendToClient()
    {
        if (!$this->isAllowed()) {
            throw new NotAllowed();
        }

        $fullPath = $this->getFullPath();
        // Must be fresh start
        if (headers_sent()) {
            die('Headers Sent');
        }

        // Required for some browsers
        if (ini_get('zlib.output_compression')) {
            ini_set('zlib.output_compression', 'Off');
        }

        // File Exists?
        if (file_exists($fullPath)) {
            // Parse Info / Get Extension
            $fsize = filesize($fullPath);
            $ctype = $this->getContentTypeByExtension();

            header('Pragma: public'); // required
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false); // required for certain browsers
            header('Content-Type: ' . $ctype);
            //header('Content-Disposition: attachment; filename="' . basename($fullPath) . '";');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . $fsize);
            ob_clean();
            flush();
            readfile($fullPath);
            exit;
        } else {
            die('File Not Found');
        }
    }


}
