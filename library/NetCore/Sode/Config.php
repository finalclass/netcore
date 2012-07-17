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

namespace NetCore\Sode;
use \NetCore\Configurable\StaticConfigurator;


class Config
{

    /**
     * @var array
     */
    private $options = array();

    /**
     * @param array $cfg
     */
    public function __construct($cfg = array())
    {
        $this->setConfig($cfg);
    }

    public function setConfig($cfg = array())
    {
        if($cfg instanceof \NetCore\Sode\Config) {
            $this->fromArray($cfg->toArray());
            $this->config = $cfg;
        } else if(is_array($cfg)) {
            $this->fromArray($cfg);
        } else if($cfg instanceof Zend_Config) {
            $this->fromArray($cfg->toArray());
        }
    }

    /**
     * @param array $arr
     * @return void
     */
    public function fromArray($arr = array())
    {
        StaticConfigurator::SetOptions($this, $arr);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->options;
    }

    /**
     * @param string $login
     * @return \NetCore\Sode\Config
     */
    public function setLogin($login)
    {
        $this->options['login'] = $login;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return isset($this->options['login']) ? $this->options['login'] : '';
    }

    /**
     * @param string $password
     * @return \NetCore\Sode\Config
     */
    public function setPassword($password)
    {
        $this->options['password'] = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return isset($this->options['password']) ? $this->options['password'] : '';
    }

    /**
     * @param string $companyId
     * @return \NetCore\Sode\Config
     */
    public function setCompanyId($companyId)
    {
        $this->options['company_id'] = $companyId;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompanyId()
    {
        return isset($this->options['company_id']) ? $this->options['company_id'] : '';
    }

    /**
     * @param string $merchant
     * @return \NetCore\Sode\Config
     */
    public function setMerchant($merchant)
    {
        $this->options['merchant'] = $merchant;
        return $this;
    }

    /**
     * @return string
     */
    public function getMerchant()
    {
        return isset($this->options['merchant']) ? $this->options['merchant'] : '';
    }

    /**
     * @param string $place
     * @return \NetCore\Sode\Config
     */
    public function setPlace($place)
    {
        $this->options['place'] = $place;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlace()
    {
        return isset($this->options['place']) ? $this->options['place'] : '';
    }

    /**
     * @param string $przelewy24Id
     * @return \NetCore\Sode\Config
     */
    public function setPrzelewy24Id($przelewy24Id)
    {
        $this->options['przelewy24_id'] = $przelewy24Id;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrzelewy24Id()
    {
        return isset($this->options['przelewy24_id']) ? $this->options['przelewy24_id'] : '';
    }

    /**
     * @param string $banNumber
     * @return \NetCore\Sode\Config
     */
    public function setBanNumber($banNumber)
    {
        $this->options['ban_number'] = $banNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getBanNumber()
    {
        return isset($this->options['ban_number']) ? $this->options['ban_number'] : '';
    }

    /**
     * @param string $banBankName
     * @return \NetCore\Sode\Config
     */
    public function setBanBankName($banBankName)
    {
        $this->options['ban_bank_name'] = $banBankName;
        return $this;
    }

    /**
     * @return string
     */
    public function getBanBankName()
    {
        return isset($this->options['ban_bank_name']) ? $this->options['ban_bank_name'] : '';
    }

    /**
     * @param string $invoiceType
     * @return \NetCore\Sode\Config
     */
    public function setInvoiceType($invoiceType)
    {
        $this->options['invoice_type'] = $invoiceType;
        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceType()
    {
        return isset($this->options['invoice_type']) ? $this->options['invoice_type'] : '';
    }

    /**
     * @param int $tax
     * @return \NetCore\Sode\Config
     */
    public function setTax($tax)
    {
        $this->options['tax'] = $tax;
        return $this;
    }

    /**
     * @return int
     */
    public function getTax()
    {
        return isset($this->options['tax']) ? $this->options['tax'] : '';
    }


    /**
     * @param $value
     * @return \NetCore\Sode\Config
     *
     */
    public function setSodeUrl($value)
    {
        $this->options['sode_url'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getSodeUrl()
    {
        return isset($this->options['sode_url']) ? $this->options['sode_url'] : 'https://www.sode.pl';
    }


}