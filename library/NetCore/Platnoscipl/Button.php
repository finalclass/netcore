<?php

namespace NetCore\Platnoscipl;

class Button
{

    /**
     * @var array
     */
    private $options = array();

    public function __construct($options = array())
    {
        $this->setOptions($options['platnoscipl']);
    }

    /**
     * @param array $options
     * @return \NetCore\Platnoscipl\Button
     */
    public function platnosciplButton($options = array())
    {
        $this->setOptions($options);
        return $this;
    }

    /**
     *
     * @param array $options
     * @throws \InvalidArgumentException
     * @return \NetCore\Platnoscipl\Button
     */
    public function setOptions(array $options = array())
    {
        if (!is_array($options)) {
            throw new \InvalidArgumentException('Wrong data type given. Expected array or Zend_Config object', 500);
        }
        \NetCore\Configurable\StaticConfigurator::setOptions($this, $options);
        return $this;
    }

    public function getJavaScriptLink()
    {
        return $this->getUrlPlatnosci()
                            . '/UTF/js/' . $this->getPosId() . '/' . substr($this->getKey1(), 0, 2)
                            . '/paytype.js';
    }

    public function __toString()
    {
        $values = array();
        $out = array();

        // -----------
        // FORM START
        // -----------
        $out[] = $this->renderFormStart();

        //BANKS
        $out[] = $this->renderBanks();

//        //TEST
//        $values[] = 't';
//        $out[] = $this->renderHidden('pay_type', 't');

        //FIRST NAME
        $values[] = $this->getFirstName();
        $out[] = $this->renderHidden('first_name', $this->getFirstName());


        //LAST NAME
        $values[] = $this->getLastName();
        $out[] = $this->renderHidden('last_name', $this->getLastName());

        //EMAIL
        $values[] = $this->getEmail();
        $out[] = $this->renderHidden('email', $this->getEmail());


        //POS_ID
        $values[] = $this->getPosId();
        $out[] = $this->renderHidden('pos_id', $this->getPosId());

        //POS_AUTH_KEY
        $values[] = $this->getPosAuthKey();
        $out[] = $this->renderHidden('pos_auth_key', $this->getPosAuthKey());

        //SESSION_ID
        $values[] = $this->getSessionId();
        $out[] = $this->renderHidden('session_id', $this->getSessionId());

        //AMOUNT
        $values[] = $this->getAmount();
        $out[] = $this->renderHidden('amount', $this->getAmount() * 100);

        //ORDER_ID
        $values[] = $this->getOrderId();
        $out[] = $this->renderHidden('order_id', $this->getOrderId());

        //DESC
        $values[] = $this->getDesc();
        $out[] = $this->renderHidden('desc', $this->getDesc());

        //CLIENT_ID
        $values[] = $this->getClientIp();
        $out[] = $this->renderHidden('client_ip', $this->getClientIp());

        //JS
        $values[] = 0;
        $out[] = $this->renderHidden('js', 0);

        /*//TIME
        $time = time();
        $values[] = $time;
        $out[] = $this->renderHidden('ts', $time);*/

        /*//SIG
        $out[] = $this->renderHidden('sig', md5(join('', $values)));*/

        //SUBMIT;
        $out[] = $this->getSubmitButton();

        // ---------
        // FORM END
        // ---------
        $out[] = $this->renderFormEnd();
        return join("\n", $out);
    }

    /**
     * @return string
     */
    private function renderBanks()
    {
        return '<script language="JavaScript" type="text/javascript"> PlnDrawRadioImg(7);</script>';
    }

    /**
     * @return string
     */
    private function renderFormStart()
    {
        return '<form action="' . $this->getUrlPlatnosci() . '/UTF/NewPayment" '
                . ' method="POST"'
                . ' name="payform">';
    }

    /**
     * @return string
     */
    private function renderFormEnd()
    {
        return '</form>'
                . '<script language="JavaScript" type="text/javascript"> '
                . 'document.forms["payform"].js.value=1;'
                . '</script>';

    }

    private function renderHidden($name, $value)
    {
        return '<input type="hidden" name="' . $name . '" value="' . $value . '" />';
    }

    /**
     * @param $value
     * @return \NetCore\Platnoscipl\Button
     */
    public function setFirstName($value)
    {
        $this->options['first_name'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return isset($this->options['first_name']) ? $this->options['first_name'] : '';
    }

    /**
     * @param $value
     * @return \NetCore\Platnoscipl\Button
     */
    public function setLastName($value)
    {
        $this->options['last_name'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return isset($this->options['last_name']) ? $this->options['last_name'] : '';
    }

    /**
     * @param $value
     * @return \NetCore\Platnoscipl\Button
     */
    public function setEmail($value)
    {
        $this->options['email'] = $value;
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
     * @param $value
     * @return \NetCore\Platnoscipl\Button
     */
    public function setPosId($value)
    {
        $this->options['pos_id'] = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getPosId()
    {
        return isset($this->options['pos_id']) ? $this->options['pos_id'] : 0;
    }

    /**
     * @param $value
     * @return \NetCore\Platnoscipl\Button
     */
    public function setPosAuthKey($value)
    {
        $this->options['pos_auth_key'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPosAuthKey()
    {
        return isset($this->options['pos_auth_key']) ? $this->options['pos_auth_key'] : '';
    }


    /**
     * @param $value
     * @return \NetCore\Platnoscipl\Button
     */
    public function setSessionId($value)
    {
        $this->options['session_id'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getSessionId()
    {
        if (!isset($this->options['session_id'])) {
            $this->options['session_id'] = md5(Zend_Session::getId() . time());
        }
        return $this->options['session_id'];
    }

    /**
     * @param $value
     * @return \NetCore\Platnoscipl\Button
     */
    public function setAmount($value)
    {
        $this->options['amount'] = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return isset($this->options['amount']) ? $this->options['amount'] : 0;
    }

    /**
     * @param $value
     * @return \NetCore\Platnoscipl\Button
     */
    public function setOrderId($value)
    {
        $this->options['order_id'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return isset($this->options['order_id']) ? $this->options['order_id'] : 0;
    }

    /**
     * @param $value
     * @return \NetCore\Platnoscipl\Button
     */
    public function setDesc($value)
    {
        $this->options['desc'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getDesc()
    {
        return isset($this->options['desc']) ? $this->options['desc'] : '';
    }

    /**
     * @param string $value
     * @return \NetCore\Platnoscipl\Button
     */
    public function setClientIp($value)
    {
        $this->options['client_ip'] = $value;
        return $this;
    }

    /**
     * @return string default is $_SERVER["REMOTE_ADDR"]
     */
    public function getClientIp()
    {
        return isset($this->options['client_ip']) ? $this->options['client_ip'] : $_SERVER["REMOTE_ADDR"];
    }

    /**
     * @param $value
     * @return \NetCore\Platnoscipl\Button
     */
    public function setUrlPlatnosci($value)
    {
        $this->options['url_platnosci'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrlPlatnosci()
    {
        return isset($this->options['url_platnosci'])
                ? $this->options['url_platnosci'] : 'https://www.platnosci.pl/paygw';
    }

    /**
     * @param string $value
     * @return \NetCore\Platnoscipl\Button
     */
    public function setKey1($value)
    {
        $this->options['key1'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey1()
    {
        return isset($this->options['key1']) ? $this->options['key1'] : '';
    }

    /**
     * @param $value
     * @return \NetCore\Platnoscipl\Button
     */
    public function setSubmitLabel($value)
    {
        $this->options['submit_label'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubmitLabel()
    {
        if (!isset($this->options['submit_label'])) {
            $this->options['submit_label'] = 'Send';
        }
        return $this->options['submit_label'];
    }

    /**
     *
     * @param $value
     * @return \NetCore\Platnoscipl\Button
     */
    public function setSubmitButton($value)
    {
        $this->options['submit_button'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubmitButton()
    {
        return isset($this->options['submit_button'])
                ? $this->options['submit_button']
                : '<input type="submit" value="' . $this->getSubmitLabel() . '">';
    }

}
