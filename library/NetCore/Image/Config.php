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

namespace NetCore\Image;

use \NetCore\Configurable\OptionsAbstract;
use \NetBricks\Image\Exception\WrongConversionType;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 05.03.12
 * @time: 10:06
 */
class Config extends OptionsAbstract
{

    protected $options = array(
        'source' => '',
        'width' => 800,
        'height' => 600,
        'ratio_width' => false,
        'ratio_height' => false,
        'ratio_no_zoom_in' => false,
        'auto_convert_by_extension' => true,
        'convert_to' => 'jpg',
        'jpeg_quality' => 80,
        'png_compression_level' => 2,
    );

    /**
     * @param int $value value between 0 and 9. 0 is no compression (best quality)
     * @return \NetCore\Image\Config
     */
    public function setPngCompressionLevel($value)
    {
        $this->options['png_compression_level'] = (int)$value;
        return $this;
    }

    /**
     * @return int
     */
    public function getPngCompressionLevel()
    {
        return (int)@$this->options['png_compression_level'];
    }

    /**
     * @param int $value value between 0 and 100 (100 is best quality)
     * @return \NetCore\Image\Config
     */
    public function setJpegQuality($value)
    {
        $this->options['jpeg_quality'] = (int)$value;
        return $this;
    }

    /**
     * @return int
     */
    public function getJpegQuality()
    {
        return (int)@$this->options['jpeg_quality'];
    }

    /**
     * @param string $value
     * @return \NetCore\Image\Config
     */
    public function setSource($value)
    {
        $this->options['source'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return (string)@$this->options['source'];
    }

    /**
     * @param boolean $value
     * @return \NetCore\Image\Config
     */
    public function setRatioHeight($value)
    {
        $this->options['ratio_height'] = (boolean)$value;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getRatioHeight()
    {
        return (boolean)@$this->options['ratio_height'];
    }

    /**
     * @param boolean $value
     * @return \NetCore\Image\Config
     */
    public function setRatioWidth($value)
    {
        $this->options['ratio_width'] = (boolean)$value;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getRatioWidth()
    {
        return (boolean)@$this->options['ratio_width'];
    }


    /**
     * @param int $value
     * @return \NetCore\Image\Config
     */
    public function setHeight($value)
    {
        $this->options['height'] = (int)$value;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return (int)@$this->options['height'];
    }

    /**
     * @param int $value
     * @return \NetCore\Image\Config
     */
    public function setWidth($value)
    {
        $this->options['width'] = (int)$value;
        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return (int)@$this->options['width'];
    }

    /**
     * @param boolean $value
     * @return \NetCore\Image\Config
     */
    public function setRatioNoZoomIn($value)
    {
        $this->options['ratio_no_zoom_in'] = (boolean)$value;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getRatioNoZoomIn()
    {
        return (boolean)@$this->options['ratio_no_zoom_in'];
    }

    /**
     * @param boolean $value
     * @return \NetCore\Image\Config
     */
    public function setAutoConvertByExtension($value)
    {
        $this->options['auto_convert_by_extension'] = (boolean)$value;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getAutoConvertByExtension()
    {
        return (boolean)@$this->options['auto_convert_by_extension'];
    }

    /**
     * @param string $value possible values: jpg, jpeg, png, gif
     * @throws \NetBricks\Image\Exception\WrongConversionType
     * @return \NetCore\Image\Config
     */
    public function setConvertTo($value)
    {
        switch($value) {
            case 'jpg':
            case 'jpeg':
                $this->options['convert_to'] = 'jpg';
                break;
            case 'png':
            case 'gif':
                $this->options['convert_to'] = (string)$value;
                break;
            default:
                throw new WrongConversionType('Specified conversion type: ' . $value . ' is not supported');
                break;
        }
        return $this;
    }

    /**
     * @return string one of jpg, png and gif
     */
    public function getConvertTo()
    {
        return (string)@$this->options['convert_to'];
    }

}
