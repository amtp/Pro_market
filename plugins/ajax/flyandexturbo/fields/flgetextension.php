<?php

/**
 * @package   FL Yandex Turbo Plugin
 * @author    Дмитрий Васюков http://fictionlabs.ru
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.form.formfield');
 
class JFormFieldFLGetExtension extends JFormField
{ 
	protected $type = 'flgetextension';
 	
 	// Get Label Function 

	protected function getLabel()
	{	
		$html[] = '<div class="alert alert-info">';
		$html[] = '<h4>Поддержка данного компонента платная</h4>';
		$html[] = '<div>Приобрести расширение для данного компонента можно на странице плагина.</div>';
		$html[] = '<div style="margin-top:10px;"><a class="btn" href="https://fictionlabs.ru/razrabotka/fl-yandex-turbo" target="_blank">Перейти</a></div>';

		return '</div>' . implode('', $html);
	}

	// Get Input Function

	protected function getInput()
	{	
		return;
	}
}