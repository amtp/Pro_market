<?php
/**
 * @package   FL Yandex Turbo Plugin
 * @author    Дмитрий Васюков http://fictionlabs.ru
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('JPATH_PLATFORM') or die;

class JFormFieldFLK2Categories extends JFormFieldList
{
	protected $type = 'flk2categories';
	
	// Get Input Function

	protected function getInput()
	{

		if (!JFile::exists(JPATH_ADMINISTRATOR.'/components/com_k2/k2.php') || !JComponentHelper::getComponent('com_k2', true)->enabled) {
			return;
		}

		$html = array();
		$attr = '';

		// Initialize some field attributes.
		$attr .= !empty($this->class) ? ' class="' . $this->class . '"' : '';
		$attr .= !empty($this->size) ? ' size="' . $this->size . '"' : '';
		$attr .= $this->multiple ? ' multiple' : '';
		$attr .= $this->required ? ' required aria-required="true"' : '';
		$attr .= $this->autofocus ? ' autofocus' : '';

		// To avoid user's confusion, readonly="true" should imply disabled="true".
		if ((string) $this->readonly == '1' || (string) $this->readonly == 'true' || (string) $this->disabled == '1'|| (string) $this->disabled == 'true') {
			$attr .= ' disabled="disabled"';
		}

		// Initialize JavaScript field attributes.
		$attr .= $this->onchange ? ' onchange="' . $this->onchange . '"' : '';

		$options = $this->getOptions();

		// Create a read-only list (no name) with hidden input(s) to store the value(s).
		if ((string) $this->readonly == '1' || (string) $this->readonly == 'true') {
			$html[] = JHtml::_('select.genericlist', $options, '', trim($attr), 'value', 'text', $this->value, $this->id);

			// E.g. form field type tag sends $this->value as array
			if ($this->multiple && is_array($this->value)) {
				if (!count($this->value)) {
					$this->value[] = '';
				}

				foreach ($this->value as $value){
					$html[] = '<input type="hidden" name="' . $this->name . '" value="' . htmlspecialchars($value, ENT_COMPAT, 'UTF-8') . '"/>';
				}
			} else {
				$html[] = '<input type="hidden" name="' . $this->name . '" value="' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '"/>';
			}
		}
		else {	
			if (!is_array($this->value)) {
				$this->value = array_map('trim', explode(',', $this->value));
			}
			
			$html[] = JHtml::_('select.genericlist', $options, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);
		}

		return JHtml::_('select.genericlist', $options, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);
	}

	// Get Options Function

	public function getOptions() 
	{
		$options 	= array();
		$db 		= JFactory::getDbo();
		$query 		= "SELECT id, name FROM #__k2_categories WHERE trash != 1";
		$db->setQuery($query);
		$result 	= $db->loadObjectList();

		if (!empty($result)) {
			foreach ($result as $option) {
				$options[] = JHtml::_('select.option', $option->id, $option->name);
			}
		}

		return $options;
	}
}