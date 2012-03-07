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

class Client
{

    /**
     * @var array
     */
    private $options = array();

    /**
     * @static
     * @param array $options
     * @return \NetCore\Sode\Client
     */
    static public function Factory($options = array())
    {
        return new \NetCore\Sode\Client($options);
    }

    /**
     * @param array $options
     */
    public function __construct($options = array())
    {
        $this->fromArray($options);
    }

    /**
     * @param array $options
     * @return void
     */
    public function fromArray(array $options = array())
    {
        StaticConfigurator::SetOptions($this, $options);
    }

    /**
     * @return \DOMElement
     */
    public function toDOMElement()
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $client = $doc->createElement('client');

        $client->setAttribute('id', $this->getId());
        if($this->getName()) {
            $client->appendChild($doc->createElement('name', $this->getName()));
        }
        if($this->getNIP()) {
            $client->appendChild($doc->createElement('nip', $this->getNIP()));
        }
        if($this->getCity()) {
            $client->appendChild($doc->createElement('city', $this->getCity()));
        }
        if($this->getPostcode()) {
            $client->appendChild($doc->createElement('postcode', $this->getPostcode()));
        }
        if($this->getAddress()) {
            $client->appendChild($doc->createElement('address', $this->getAddress()));
        }
        if($this->getEmail()) {
            $client->appendChild($doc->createElement('email', $this->getEmail()));
        }
        if($this->getBankName()) {
            $client->appendChild($doc->createElement('bank_name', $this->getBankName()));
        }
        if($this->getBan()) {
            $client->appendChild($doc->createElement('ban', $this->getBan()));
        }
        if($this->getPhone()) {
            $client->appendChild($doc->createElement('phone', $this->getPhone()));
        }
        if($this->getExternalId()) {
            $client->appendChild($doc->createElement('external_id', $this->getExternalId()));
        }
        if($this->getTraderId()) {
            $client->appendChild($doc->createElement('trader_id', $this->getTraderId()));
        }
        if($this->getIsIndividual()) {
            $client->appendChild($doc->createElement('is_individual', $this->getIsIndividual()));
        }
        

        return $client;
    }

    /**
     * @return \DOMElement
     */
    public function toDOMElementWithAttributes()
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $client = $doc->createElement('client');

        if($this->getId()) {
            $client->setAttribute('id', $this->getId());
        } else {
            if($this->getName()) {
                $client->setAttribute('company', $this->getName());
            }
            if($this->getNIP()) {
                $client->setAttribute('nip', $this->getNIP());
            }
            if($this->getCity()) {
                $client->setAttribute('city', $this->getCity());
            }
            if($this->getPostcode()) {
                $client->setAttribute('city_code', $this->getPostcode());
            }
            if($this->getAddress()) {
                $client->setAttribute('address', $this->getAddress());
            }
            if($this->getEmail()) {
                $client->setAttribute('email', $this->getEmail());
            }
            if($this->getBankName()) {
                $client->setAttribute('ban_bankname', $this->getBankName());
            }
            if($this->getBan()) {
                $client->setAttribute('ban_number', $this->getBan());
            }
            if($this->getPhone()) {
                $client->setAttribute('phone', $this->getPhone());
            }
            if($this->getExternalId()) {
                $client->setAttribute('seller_client_id', $this->getExternalId());
            }
            if($this->getTraderId()) {
                $client->setAttribute('trader_id', $this->getTraderId());
            }
            
            $client->setAttribute('is_individual', $this->getIsIndividual());
        }
        
        return $client;
    }


    /**
     * @return array
     */
    public function toArray()
    {
        return $this->options;
    }

    /**
     * @param $id
     * @return \NetCore\Sode\Client
     */
    public function setId($id)
    {
        $this->options['id'] = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return isset($this->options['id']) ? $this->options['id'] : 0;
    }

    /**
     * @param $name
     * @return \NetCore\Sode\Client
     */
    public function setName($name)
    {
        $this->options['name'] = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return isset($this->options['name']) ? $this->options['name'] : '';
    }

    /**
     * @param $nip
     * @return \NetCore\Sode\Client
     */
    public function setNIP($nip)
    {
        $this->options['nip'] = $nip;
        return $this;
    }

    /**
     * @return string
     */
    public function getNIP()
    {
        return isset($this->options['nip']) ? $this->options['nip'] : '';
    }

    /**
     * @param $city
     * @return \NetCore\Sode\Client
     */
    public function setCity($city)
    {
        $this->options['city'] = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return isset($this->options['city']) ? $this->options['city'] : '';
    }

    /**
     * @param $postcode
     * @return \NetCore\Sode\Client
     */
    public function setPostcode($postcode)
    {
        $this->options['postcode'] = $postcode;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostcode()
    {
        return isset($this->options['postcode']) ? $this->options['postcode'] : '';
    }

    /**
     * @param $address
     * @return \NetCore\Sode\Client
     */
    public function setAddress($address)
    {
        $this->options['address'] = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return isset($this->options['address']) ? $this->options['address'] : '';
    }

    /**
     * @param $email
     * @return \NetCore\Sode\Client
     */
    public function setEmail($email)
    {
        $this->options['email'] = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return isset($this->options['email']) ? $this->options['email'] : '';
    }

    /**
     * @param $bankName
     * @return \NetCore\Sode\Client
     */
    public function setBankName($bankName)
    {
        $this->options['bank_name'] = $bankName;
        return $this;
    }

    /**
     * @return string
     */
    public function getBankName()
    {
        return isset($this->options['bank_name']) ? $this->options['email'] : '';
    }

    public function setBan($ban)
    {
        $this->options['ban'] = $ban;
        return $this;
    }

    /**
     * @return string
     */
    public function getBan()
    {
        return isset($this->options['ban']) ? $this->options['ban'] : '';
    }

    /**
     * @param $phone
     * @return \NetCore\Sode\Client
     */
    public function setPhone($phone)
    {
        $this->options['phone'] = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return isset($this->options['phone']) ? $this->options['phone'] : '';
    }

    /**
     * @param $externalId
     * @return \NetCore\Sode\Client
     */
    public function setExternalId($externalId)
    {
        $this->options['external_id'] = intval($externalId);
        return $this;
    }

    /**
     * @return string
     */
    public function getExternalId()
    {
        return isset($this->options['external_id']) ? $this->options['external_id'] : 0;
    }

    /**
     * @param $traderId
     * @return \NetCore\Sode\Client
     */
    public function setTraderId($traderId)
    {
        $this->options['trader_id'] = $traderId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTraderId()
    {
        return isset($this->options['trader_id']) ? $this->options['trader_id'] : '';
    }

    /**
     * @param $isIndividual
     * @return \NetCore\Sode\Client
     */
    public function setIsIndividual($isIndividual)
    {
        $this->options['is_individual'] = $isIndividual;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsIndividual()
    {
        return isset($this->options['is_individual']) ? $this->options['is_individual'] : '';
    }

}
