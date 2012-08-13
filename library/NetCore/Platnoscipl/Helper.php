<?php

namespace Fasolka\Platnoscipl;

class Helper
{ 

    /**
     * @var array
     */
    private $errorMessages = array(
        "100" => "Brak lub błedna wartosc parametru pos id",
        "101" => "Brak parametru session id",
        "102" => "Brak parametru ts",
        "103" => "Brak lub błędna wartość parametru sig",
        "104" => "Brak parametru desc",
        "105" => "Brak parametru client ip",
        "106" => "Brak parametru first name",
        "107" => "Brak parametru last name",
        "108" => "Brak parametru street",
        "109" => "Brak parametru city",
        "110" => "Brak parametru post code",
        "111" => "Brak parametru amount",
        "112" => "Błedny numer konta bankowego",
        "113" => "Brak parametru email",
        "114" => "Brak numeru telefonu",
        "200" => "Inny chwilowy błąd",
        "201" => "Inny chwilowy błąd bazy danych",
        "202" => "Pos o podanym identyfikatorze jest zablokowany",
        "203" => "Niedozwolona wartosc pay type dla danego pos id",
        "204" => "Podana metoda płatnosci (wartosc pay type) jest chwilowo zablokowana dla danego pos id, np. przerwa konserwacyjna bramki płatniczej",
        "205" => "Kwota transakcji mniejsza od wartosci minimalnej",
        "206" => "Kwota transakcji wieksza od wartosci maksymalnej",
        "207" => "Przekroczona wartość wszystkich transakcji dla jednego klienta w ostatnim przedziale czasowym",
        "208" => "Pos działa w wariancie ExpressPayment lecz nie nastapiła aktywacja tego wariantu współpracy (czekamy na zgode działu obsługi klienta)",
        "209" => "Błędny numer pos id lub pos auth key",
        "500" => "Transakcja nie istnieje",
        "501" => "Brak autoryzacji dla danej transakcji",
        "502" => "Transakcja rozpoczeta wczesniej",
        "503" => "Autoryzacja do transakcji była juz przeprowadzana",
        "504" => "Transakcja anulowana wczesniej",
        "505" => "Transakcja przekazana do odbioru wczesniej",
        "506" => "Transakcja juz odebrana",
        "507" => "Bład podczas zwrotu srodków do klienta",
        "599" => "Błedny stan transakcji, np. nie mozna uznac transakcji kilka razy lub inny, prosimy o kontakt",
        "999" => "Inny bład krytyczny - prosimy o kontakt"
    );

    /**
     * @var string
     */
    protected $posId = '';

    /**
     * @var string
     */
    protected $urlPlatnosci = 'https://www.platnosci.pl/paygw';

    /**
     * @var string
     */
    protected $key1 = '';

    /**
     * @var string
     */
    protected $sessionId = '';

    /**
     * @var string
     */
    protected $lastResult = '';


    /**
     * @param array
     * @return \Fasolka\Platnoscipl\Helper
     */
    public function direct($options = array())
    {
        \NetCore\Configurable\StaticConfigurator::setOptions($this, $options);
        return $this;
    }

    /**
     * @return \Fasolka\Platnoscipl\Helper
     */
    public function cancelPayment()
    {
        $ts = time();
        $sig = md5($this->posId . $this->sessionId . $ts . $this->key1);
        $client = new Zend_Http_Client();
        $client->setUri($this->urlPlatnosci . '/UTF/Payment/cancel/txt');
        $client->setMethod(Zend_Http_Client::POST);
        $client->setParameterPost(array(
                                       'pos_id' => $this->posId,
                                       'session_id' => $this->sessionId,
                                       'ts' => $ts,
                                       'sig' => $sig
                                  ));
        $this->lastResult = $client->request()->getBody();
        return $this;
    }

    /**
     * @return \Fasolka\Platnoscipl\Helper
     */
    public function getPayment()
    {
        $ts = time();
        $sig = md5($this->posId . $this->sessionId . $ts . $this->key1);

        $client = new Zend_Http_Client();
        $client->setUri($this->urlPlatnosci . '/UTF/Payment/get/txt');
        $client->setMethod(Zend_Http_Client::POST);
        $client->setParameterPost(array(
                                       'pos_id' => $this->posId,
                                       'session_id' => $this->sessionId,
                                       'ts' => $ts,
                                       'sig' => $sig
                                  ));

        $this->lastResult = $client->request()->getBody();
        return $this;
    }

    /**
     * @return \Fasolka\Platnoscipl\Helper
     */
    public function confirmPayment()
    {
        $ts = time();
        $sig = md5($this->posId . $this->sessionId . $ts . $this->key1);

        $client = new Zend_Http_Client();
        $client->setUri($this->urlPlatnosci . '/UTF/Payment/confirm/txt');
        $client->setMethod(Zend_Http_Client::POST);
        $client->setParameterPost(array(
                                       'pos_id' => $this->posId,
                                       'session_id' => $this->sessionId,
                                       'ts' => $ts,
                                       'sig' => $sig
                                  ));

        $this->lastResult = $client->request()->getBody();
        return $this;
    }


    /**
     * @param int $errorCode
     * @return string
     */
    public function getErrorMessage($errorCode)
    {
        return isset($this->errorMessages[$errorCode])
                ? $this->errorMessages[$errorCode] : 'Message code invalid';
    }


    /**
     * @param string $string
     * @return array
     */
    private function responseToArray($string)
    {
        $filter = new Zend_Filter_StringTrim();
        $array = explode("\n", $string);
        $out = array();
        foreach ($array as $line) {
            $lineExploded = explode(':', $line);
            if(count($lineExploded) != 2) {
                continue;
            }
            list($key, $val) = $lineExploded;
            $out[$filter->filter($key)] = $filter->filter($val);
        }

        return $out;
    }


    /**
     * @param string $key1
     */
    public function setKey1($key1)
    {
        $this->key1 = $key1;
    }

    /**
     * @return string
     */
    public function getKey1()
    {
        return $this->key1;
    }


    /**
     * @return array
     */
    public function getLastResultArray()
    {
        return $this->responseToArray($this->lastResult);
    }

    /**
     * @return object
     */
    public function getLastResultObject()
    {
        return (object)$this->responseToArray($this->lastResult);
    }


    /**
     * @return string
     */
    public function getLastResult()
    {
        return $this->lastResult;
    }

    /**
     * @param string $posId
     */
    public function setPosId($posId)
    {
        $this->posId = $posId;
    }

    /**
     * @return string
     */
    public function getPosId()
    {
        return $this->posId;
    }

    /**
     * @param string $urlPlatnosci
     */
    public function setUrlPlatnosci($urlPlatnosci)
    {
        $this->urlPlatnosci = $urlPlatnosci;
    }

    /**
     * @return string
     */
    public function getUrlPlatnosci()
    {
        return $this->urlPlatnosci;
    }

    /**
     * @param string $sessionId
     * @return \\Fasolka\Platnoscipl\Helper
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    /**
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

}
