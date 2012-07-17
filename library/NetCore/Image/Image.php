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

use \NetCore\Image\Config;
use \NetCore\Image\Exception\FileNotFound;
use \NetCore\Image\Exception\OpenFailed;
use \NetCore\Image\Exception\WrongSourceType;
use \NetCore\Image\Exception\ReadImageSizeError;
use \NetCore\Image\Exception\CalculateImageSizeError;
use \NetBricks\Image\Exception\WrongConversionType;
use \NetCore\Image\Exception as ImageException;

/**
 *
 *

$image = new Image();

$image->getConfig()
        ->setSource('/tmp/path_to_image.jpg')
        ->setWidth(800)
        ->setRatioWidth(true)
        ->setRatioNoZoomIn(true)
        ->setAutoConvertByExtension(true);

$image->save('/home/galleries/path_to.bmp');

 *
 * @author: Sel <s@finalclass.net>
 * @date: 05.03.12
 * @time: 09:44
 */
class Image
{

    protected $config;

    /**
     * @param array|string|\NetCore\Image\Config $configOrSource
     */
    public function __construct($configOrSource = array())
    {
        if($configOrSource instanceof Config) {
            $this->setConfig($configOrSource);
        } else  if(is_string($configOrSource)) {
            $this->getConfig()->setSource($configOrSource);
        } else if(is_array($configOrSource)) {
            $this->setConfig(new Config($configOrSource));
        }
    }

    /**
     * @param \NetCore\Image\Config $config
     * @return \NetCore\Image
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return \NetCore\Image\Config
     */
    public function getConfig()
    {
        if(!$this->config) {
            $this->setConfig(new Config());
        }
        return $this->config;
    }

    public function save($path)
    {
        $path = (string)$path;

        $cfg = $this->getConfig();
        $image = $this->open();
        $image = $this->resize($image);
        $newMimeType = $this->getDestinationMimeType($path);

        switch($newMimeType) {
            default:
            case 'image/jpeg':
                imagejpeg($image, $path, $cfg->getJpegQuality());
                break;
            case 'image/png':
                imagepng($image, $path, $cfg->getPngCompressionLevel());
                break;
            case 'image/gif':
                imagegif($image, $path);
                break;
        }

        imagedestroy($image);
        return $this;
    }

    private function getDestinationMimeType($destinationPath)
    {
        $cfg = $this->getConfig();
        if($cfg->getAutoConvertByExtension()) {
            $extension = pathinfo($destinationPath, PATHINFO_EXTENSION);
        } else {
            $extension = $cfg->getConvertTo();
        }

        $mime = null;
        switch($extension) {
            case 'jpeg':
            case 'jpg':
                $mime = 'image/jpeg';
                break;
            case 'gif':
                $mime = 'image/gif';
                break;
            case 'png':
                $mime = 'image/png';
                break;
        }

        if(!$mime) {
            throw new WrongConversionType('destination extension: ' . $extension
                    . ' is not supported. Supported types: jpg, png, gif');
        }

        return $mime;
    }


    public function send()
    {
        $image = $this->open();
        $image = $this->resize($image);
        ob_clean();
        header('Content-type: image/jpeg');
        $name = explode(".", basename($_SERVER['REQUEST_URI']));
        header("Content-Disposition: inline; filename=" . $name[0] . "_t.jpg");
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($_SERVER['REQUEST_URI'])) . ' GMT');
        header("Cache-Control: public");
        header("Pragma: public");
        imagejpeg($image);
    }

    private function resize($image)
    {
        list($actualWidth, $actualHeight) = $this->getActualSize($image);
        list($width, $height) = $this->calculateSize($image);
        $out = imagecreatetruecolor($width, $height);
        imagecopyresampled($out, $image, 0, 0, 0, 0, $width, $height, $actualWidth, $actualHeight);
        return $out;
    }


    /**
     * @param $image
     * @return array returns array width sizes: array(width, height)
     * @throws \NetCore\Image\Exception\ReadImageSizeError
     */
    private function getActualSize($image)
    {
        $width = imagesx($image);
        $height = imagesy($image);
        if(!$width || !$height) {
            throw new ReadImageSizeError();
        }
        return array($width, $height);
    }

    private function getActualRatio($image)
    {
        list($actualWidth, $actualHeight) = $this->getActualSize($image);
        return $actualWidth / $actualHeight;
    }

    private function calculateSize($image)
    {
        $cfg = $this->getConfig();
        list($actualWidth, $actualHeight) = $this->getActualSize($image);
        $ratio = $actualWidth / $actualHeight;
        $width = $cfg->getRatioWidth() ? $cfg->getHeight() * $ratio : $cfg->getWidth();
        $height = $cfg->getRatioHeight() ? $cfg->getWidth() / $ratio : $cfg->getHeight();

        $width = (int) $width;
        $height = (int) $height;

        if($cfg->getRatioNoZoomIn() && ($width > $actualWidth || $height > $actualHeight)) {
            return array($actualWidth, $actualHeight);
        }

        if($width <= 0 || $height <= 0) {
            throw new CalculateImageSizeError('calculated width: '
                    . $width . ' or height: ' . $height . ' is invalid');
        }

        return array($width, $height);
    }

    /**
     * @return null|resource
     * @throws \NetCore\Image\Exception\FileNotFound
     * @throws \NetCore\Image\Exception\OpenFailed
     * @throws \NetCore\Image\Exception\WrongSourceType
     */
    private function open()
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $path = $this->getConfig()->getSource();
        $mimeType = $finfo->file($path);
        if(!$mimeType) {
            throw new FileNotFound();
        }

        $result = null;
        switch($mimeType) {
            case 'image/gif':
                $result = imagecreatefromgif($path);
                break;
            case 'image/png':
                $result = imagecreatefrompng($path);
                break;
            case 'image/jpeg':
                $result = imagecreatefromjpeg($path);
                break;
        }

        if($result === null) {
            throw new WrongSourceType();
        } else if(!$result) {
            throw new OpenFailed();
        }

        return $result;
    }

}


