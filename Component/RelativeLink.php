<?php

namespace NetCore\Component;

use \NetCore\Component\Tag;

/**
 * Author: Sel <s@finalclass.net>
 * Date: 15.11.11
 * Time: 22:36
 */
class RelativeLink extends Tag
{

    protected $defaultAttributes = array('id', 'class', 'style', 'title', 'rel', 'href');

    private $selected = array();
    private $urlParams = array();

    /**
     * @static
     * @param string $optionsOrTagName
     * @return \NetCore\Component\RelativeLink
     */
    static public function factory($optionsOrTagName = 'div')
    {
        $class = get_called_class();
        return new $class($optionsOrTagName);
    }

    public function getTagName()
    {
        return 'a';
    }

    public function select($item)
    {
        $this->selected[] = $item;
        return $this;
    }

    public function addParam($paramName, $paramValue)
    {
        $this->urlParams[(string)$paramName] = (string)$paramValue;
        return $this;
    }

    public function removeParam($paramName)
    {
        unset($this->urlParams[$paramName]);
        return $this;
    }

    public function getParam($paramName)
    {
        return empty($this->urlParams[$paramName]) ? '' : $this->urlParams[$paramName];
    }

    public function getHref()
    {
        $contentSwitcherParents = $this->getParentsByType('\NetBricks\Common\ContentSwitcher\ContentSwitcher');
        $selectedParents = array();
        foreach ($contentSwitcherParents as $contentSwitcher) {
            /**
             * @var \NetBricks\Common\ContentSwitcher\ContentSwitcher $contentSwitcher
             */
            $selectedParents[] = $contentSwitcher->getSelectedCase()->getCaseName();
        }

        $selected = array_unique(
            array_values(
                array_filter(
                    array_merge($this->selected, $selectedParents))));

        
        $params = $this->renderUrlParams();
        $params = empty($params) ? '' : '?' . $params;
        return '/' . join('/', array_reverse($selected)) . $params;
    }

    private function renderUrlParams()
    {
        $params = array();
        foreach($this->urlParams as $paramName => $paramValue)
        {
            $params[] = urlencode($paramName) . '=' . urlencode($paramValue);
        }
        return join('&', $params);
    }

    /**
     * @param $value
     * @return RelativeLink
     */
    public function setRel($value)
    {
        $this->options['rel'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getRel()
    {
        return empty($this->options['rel']) ? '' : $this->options['rel'];
    }

    /**
     * @param $value
     * @return RelativeLink
     */
    public function setTitle($value)
    {
        $this->options['title'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return empty($this->options['title']) ? '' : $this->options['title'];
    }

}
