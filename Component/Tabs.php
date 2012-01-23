<?php

namespace NetCore\Component;

use \NetCore\Component\Tag;

/**
 * Author: Szymon Wygnański
 * Date: 13.09.11
 * Time: 15:15
 */
class Tabs extends Tag
{

    protected $tabs = array();

    public function render()  {?>

        <div <?php echo $this->renderTagAttributes($this->defaultAttributes); ?>>
            <ul class="<?php echo $this->getClass(); ?>_labels">
                <?php foreach($this->tabs as $t): ?>
                    <li><?php echo $this->renderVariable($t[1]);?></li>
                <?php endforeach; ?>
            </ul>
            <ul class="<?php echo $this->getClass(); ?>_tabs">
                <?php foreach($this->tabs as $t): ?>
                    <li><?php echo $this->renderVariable($t[0]); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

<?php }

    public function addTab($tab, $tabLabel, $key = null)
    {
        if($key) {
            $this->tabs[$key] = array($tab, $tabLabel);
        } else {
            $this->tabs[] = array($tab, $tabLabel);
        }
        return $this;
    }

    public function getTabs()
    {
        return $this->tabs;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return isset($this->options['class']) ? $this->options['class'] : 'language_tabs';
    }

    /**
     * @static
     * @return Tabs
     */
    static public function factory($options = array())
    {
        return parent::factory($options);
    }

}
