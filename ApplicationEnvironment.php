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
/**
 * @author: Sel <s@finalclass.net>
 * @date: 30.04.12
 * @time: 09:06
 *
 *
 * @property string isDevelopment
 * @property string isProduction
 * @property string isStaging
 *
 */
class ApplicationEnvironment
{

    private $applicationEnv = 'development';

    public function __get($varName)
    {
        $varName = @(string)$varName;
        if (!isset($varName[2])) {
            return false;
        }
        if ($varName[0] != 'i' && $varName[1] != 's') {
            return false;
        }

        $envText = substr($varName, 2);

        return $this->is($envText);
    }

    public function __set($varName, $value)
    {
        $varName = @(string)$varName;
        if (!$value) {
            $this->applicationEnv = 'development';
        }
        if (!isset($varName[2])) {
            return;
        }
        if ($varName[0] != 'i' && $varName[1] != 's') {
            return;
        }

        $envText = substr($varName, 2);
        $this->set($varName);
    }

    public function set($value)
    {
        $this->applicationEnv = strtolower(@(string)$value);
        return $this;
    }

    public function is($envText)
    {
        return strtolower($envText) == $this->applicationEnv;
    }

    public function get()
    {
        return $this->applicationEnv;
    }


    public function __call($funcName, $args = array())
    {
        if(count($args) == 0) {
            return $this->$funcName;
        }
        $this->$funcName = $args[0];
        return $this;
    }

    public function __toString()
    {
        return $this->applicationEnv;
    }

    public function __invoke()
    {
        return $this->__toString();
    }


}
