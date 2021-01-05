<?php
/**
 * @package         Add to Menu
 * @version         6.4.1
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2020 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory as JFactory;
use Joomla\CMS\Plugin\PluginHelper as JPluginHelper;
use RegularLabs\Library\Document as RL_Document;
use RegularLabs\Library\Extension as RL_Extension;
use RegularLabs\Library\Language as RL_Language;
use Joomla\CMS\Language\Text as JText;

/**
 * Module that adds menu items
 */

$user = JFactory::getUser();
if ( ! $user->authorise('core.create', 'com_menus'))
{
	return;
}

// return if Regular Labs Library plugin is not installed
jimport('joomla.filesystem.file');
if (
	! is_file(JPATH_PLUGINS . '/system/regularlabs/regularlabs.xml')
	|| ! is_file(JPATH_LIBRARIES . '/regularlabs/autoload.php')
)
{
	return;
}


// return if Regular Labs Library plugin is not enabled
if ( ! JPluginHelper::isEnabled('system', 'regularlabs'))
{
	return;
}

require_once JPATH_LIBRARIES . '/regularlabs/autoload.php';

if ( ! RL_Document::isJoomlaVersion(3, 'ADDTOMENU'))
{
	RL_Extension::disable('addtomenu', 'module');

	RL_Language::load('plg_system_regularlabs');

	JFactory::getApplication()->enqueueMessage(
		JText::sprintf('RL_ADMIN_MODULE_HAS_BEEN_DISABLED', JText::_('ADDTOMENU')),
		'error'
	);

	return;
}

jimport('joomla.filesystem.folder');
$option = JFactory::getApplication()->input->get('option');
$folder = JPATH_ADMINISTRATOR . '/components/' . $option . '/addtomenu';
if ( ! JFolder::exists($folder))
{
	$folder = JPATH_ADMINISTRATOR . '/modules/mod_addtomenu/components/' . $option;
}

if ( ! JFolder::exists($folder))
{
	return;
}

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$helper = new ModAddToMenu($params);
$helper->render();
