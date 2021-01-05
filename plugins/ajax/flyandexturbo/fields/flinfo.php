<?php

/**
 * @package   FL Yandex Turbo Plugin
 * @author    Дмитрий Васюков http://fictionlabs.ru
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.form.formfield');
 
class JFormFieldFLInfo extends JFormField
{ 
	protected $type = 'flinfo';
 	
 	// Get Label Function 

	protected function getLabel()
	{	
		JFactory::getDocument()->addScriptDeclaration("
	        jQuery(function($) {
	        	$(document).ready(function() {
					$('div[id^=\"attrib-\"] > .control-group > .control-label').hide();
					$('div[id^=\"attrib-\"] > .control-group > .controls').css('margin-left', '0');
	        	});
	        });");

		$id 	= JFactory::getApplication()->input->getString('extension_id');
		$link 	= JUri::root().'?option=com_ajax&plugin=flyandexturbo&format=raw&code='.$this->getCode($id);

		$html[] = '<div class="alert alert-info">';
		$html[] = '<h4>Ваша лента Яндекс.Турбо</h4>';
		$html[] = '<a href="'.$link.'" target="_blank">'.$link.'</a>';

		return '</div>' . implode('', $html);
	}

	// Get Input Function

	protected function getInput()
	{	
		$id 	= JFactory::getApplication()->input->getString('extension_id');
		$html 	= '<input type="hidden" name="' . $this->name . '" value="' . $this->getCode($id) . '"/>';
		return $html;
	}

	// Get Code

	protected function getCode($value)
	{	
		$code = substr(strrev(md5($value)), 0, 16);

		return $code;
	}
}