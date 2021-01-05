<?php

/**
 * @package   FL Yandex Turbo Plugin
 * @author    Дмитрий Васюков http://fictionlabs.ru
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.form.formfield');
 
class JFormFieldFLZooTypes extends JFormField
{ 
    protected $type = 'flzootypes';
    
    // Get Input Function
    
    public function getInput() {

        if (!JFile::exists(JPATH_ADMINISTRATOR.'/components/com_zoo/config.php')
                || !JComponentHelper::getComponent('com_zoo', true)->enabled) {
            return;
        }

        // load config
        require_once(JPATH_ADMINISTRATOR . '/components/com_zoo/config.php');

        // get app
        $zoo  = App::getInstance('zoo');
        $attribs = '';
        $options = array();

        if ($v = $this->element->attributes()->class) {
            $attribs .= ' class="'.$v.'"';
        } else {
            $attribs .= ' class="inputbox"';
        }

        if ($this->element->attributes()->multiple) {
            $attribs .= ' multiple="multiple"';
        }

        foreach ($zoo->application->getApplications() as $application) {
            foreach ($application->getTypes() as $type) {
                $options[] = $zoo->html->_('select.option', $type->id, $type->name);
            }

            // break after first type
            break;
        }

        return $zoo->html->_('select.genericlist', $options, $this->getName($this->fieldname), trim($attribs), 'value', 'text', $this->value, $this->id);
    }
}