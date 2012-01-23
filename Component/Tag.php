<?php

namespace NetCore\Component;

/**
 * Author: Szymon Wygnański
 * Date: 07.09.11
 * Time: 02:53
 */
class Tag extends Container
{

    protected $defaultAttributes = array('id', 'class', 'style');


    public function getDefaultAttributes()
    {
        return $this->defaultAttributes;
    }

    /**
     * @static
     * @param string $optionsOrTagName
     * @return \NetCore\Component\Tag
     */
    static public function factory($optionsOrTagName = 'div')
    {
        $class = get_called_class();
        return new $class($optionsOrTagName);
    }

    public function __construct($optionsOrTagName = 'div')
    {
        if(is_string($optionsOrTagName)) {
            $optionsOrTagName = array('tag_name' => $optionsOrTagName);
        }
        parent::__construct($optionsOrTagName);
    }

    public function render()
    {
        $attributes = $this->renderTagAttributes($this->getDefaultAttributes());
        $out = '<' . $this->getTagName() . $attributes . ' ' . $this->renderData() . '>' . PHP_EOL;

        $content = $this->getContent();
        if($content) {
            $out .= $this->renderVariable($content);
        } else {
            $out .= join(PHP_EOL, $this->children);
        }

        return $out . '</' . $this->getTagName() . '>' . PHP_EOL;
    }

    public function renderTagAttributes(array $attributes)
    {
        $htmlAttributes = '';
        foreach($attributes as $attr)
        {
            $getterClassName = 'get' . \NetCore\Configurable\StaticConfigurator::toPascalCased($attr);
            if(!method_exists($this, $getterClassName)) {
                continue;
            }
            $value = $this->$getterClassName();
            if(empty($value)) {
                continue;
            }
            $htmlAttributes .= ' ' . $attr . '="' . $value . '" ';
        }
        return $htmlAttributes;
    }

    private function renderData()
    {
        $data = $this->getData();
        $out = array();
        foreach($data as $key => $value) {
            $out[] = 'data-' . $key . '="' . addslashes(htmlentities($value)) . '"';
        }
        return join(' ', $out);
    }

    public function addData($key, $value)
    {
        $data = $this->getData();
        $data[$key] = $value;
        $this->setData($data);
        return $this;
    }

    public function removeData($key)
    {
        $data = $this->getData();
        unset($data[$key]);
        $this->setData($data);
        return $this;
    }

    public function hasData($key)
    {
        $data = $this->getData();
        return isset($data[$key]) && $data[$key];
    }

    /**
     * @param array $value
     * @return \NetCore\Component\Tag
     */
    public function setData(array $value)
    {
        $this->options['data'] = (array)$value;
        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return empty($this->options['data']) ? array() : $this->options['data'];
    }

    /**
     * @param $value
     * @return Tag
     */
    public function setContent($value)
    {
        $this->options['content'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return isset($this->options['content']) ? $this->options['content'] : '';
    }

    /**
     * @param $value
     * @return Tag
     */
    public function setClass($value)
    {
        $this->options['class'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return isset($this->options['class']) ? $this->options['class'] : '';
    }

    public function addClass($class)
    {
        $classes = explode(' ', $this->getClass());
        $classes[] = $class;
        $classes = array_unique(array_filter($classes));
        $this->setClass(join(' ', $classes));
        return $this;
    }

    public function removeClass($class)
    {
        $this->setClass( str_replace($class, '', $this->getClass()) );
        return $this;
    }

    /**
     * @param $value
     * @return Tag
     */
    public function setStyle($value)
    {
        $this->options['style'] = is_array($value) ? join(' ', $value) : $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getStyle()
    {
        return isset($this->options['style']) ? $this->options['style'] : '';
    }

    /**
     * @param $value
     * @return Tag
     */
    public function setTagName($value)
    {
        $this->options['tag_name'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getTagName()
    {
        return isset($this->options['tag_name']) ? $this->options['tag_name'] : 'div';
    }

    /**
     * @param string $value
     * @return \NetCore\Component\Tag
     */
    public function setId($value)
    {
        $this->options['id'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return empty($this->options['id']) ? '' : $this->options['id'];
    }

}
