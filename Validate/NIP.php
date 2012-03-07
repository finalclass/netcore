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

namespace NetCore\Validate;

class NIP extends \Zend_Validate_Abstract implements \Zend_Validate_Interface
{

    const NOT_NIP = 'notNIP';
    const NIP_TOO_SHORT = 'nipTooShort';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::NOT_NIP => "'%value%' does not look like a valid NIP",
        self::NIP_TOO_SHORT => "'%value%' is too short for a NIP"
    );

    public function isValid($value)
    {
        $this->_setValue($value);
        $str = preg_replace("/[^0-9]+/", "", $value);
        if (strlen($str) != 10) {
            $this->_error(self::NIP_TOO_SHORT);
            return false;
        }

        $arrSteps = array(6, 5, 7, 2, 3, 4, 5, 6, 7);
        $intSum = 0;
        for ($i = 0; $i < 9; $i++) {
            $intSum += $arrSteps[$i] * $value[$i];
        }
        $int = $intSum % 11;

        $intControlNr = ($int == 10) ? 0 : $int;
        if ($intControlNr == $value[9]) {
            return true;
        }

        $this->_error(self::NOT_NIP);
        return false;
    }

}