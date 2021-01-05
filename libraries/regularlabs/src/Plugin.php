<?php
/**
 * @package         Regular Labs Library
 * @version         20.9.11663
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2020 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

namespace RegularLabs\Library;

defined('_JEXEC') or die;

use Joomla\CMS\Application\CMSApplication as JCMSApplication;
use Joomla\CMS\Factory as JFactory;
use Joomla\CMS\Form\Form as JForm;
use Joomla\CMS\Language\Text as JText;
use Joomla\CMS\Plugin\CMSPlugin as JPlugin;
use Joomla\CMS\Plugin\PluginHelper as JPluginHelper;

class Plugin extends JPlugin
{
	public $_alias       = '';
	public $_title       = '';
	public $_lang_prefix = '';

	public $_is_admin              = false;
	public $_has_tags              = false;
	public $_enable_in_frontend    = true;
	public $_enable_in_admin       = false;
	public $_can_disable_by_url    = true;
	public $_disable_on_components = false;
	public $_protected_formats     = [];
	public $_page_types            = [];
	public $_jversion              = 3;

	private $_pass = null;

	/**
	 * @var    JCMSApplication
	 */
	protected $app;

	/**
	 * @var    \JDatabaseDriver
	 */
	protected $db;

	/**
	 * @param object  &$subject    The object to observe
	 * @param array    $config     An optional associative array of configuration settings.
	 *                             Recognized key values include 'name', 'group', 'params', 'language'
	 *                             (this list is not meant to be comprehensive).
	 */
	public function __construct(&$subject, $config = [])
	{
		if (isset($config['id']))
		{
			$this->_id = $config['id'];
		}

		parent::__construct($subject, $config);

		$this->app = JFactory::getApplication();
		$this->db  = JFactory::getDbo();

		$this->_is_admin = Document::isAdmin();

		if (empty($this->_alias))
		{
			$this->_alias = $this->_name;
		}

		if (empty($this->_title))
		{
			$this->_title = strtoupper($this->_alias);
		}

		Language::load('plg_' . $this->_type . '_' . $this->_name);
	}

	/**
	 * @return  void
	 */
	public function onAfterRoute()
	{
		if ( ! $this->passChecks())
		{
			return;
		}

		$this->handleOnAfterRoute();
	}

	/**
	 * @return  void
	 */
	public function onAfterDispatch()
	{
		if ( ! $this->passChecks())
		{
			return;
		}

		$this->handleOnAfterDispatch();

		$buffer = Document::getBuffer();

		$this->loadStylesAndScripts($buffer);

		if ( ! $buffer)
		{
			return;
		}

		if ( ! $this->changeDocumentBuffer($buffer))
		{
			return;
		}

		Document::setBuffer($buffer);
	}

	/**
	 * @return  void
	 */
	public function onAfterInitialise()
	{
		if ( ! $this->passChecks())
		{
			return;
		}

		$this->handleOnAfterInitialise();
	}

	/**
	 * @param string    $context The context of the content being passed to the plugin.
	 * @param mixed    &$row     An object with a "text" property
	 * @param mixed    &$params  Additional parameters. See {@see PlgContentContent()}.
	 * @param integer   $page    Optional page number. Unused. Defaults to zero.
	 *
	 * @return  bool
	 */
	public function onContentPrepare($context, &$article, &$params, $page = 0)
	{
		if ( ! $this->passChecks())
		{
			return true;
		}

		$area    = isset($article->created_by) ? 'article' : 'other';
		$context = (($params instanceof \JRegistry) && $params->get('rl_search')) ? 'com_search.' . $params->get('readmore_limit') : $context;

		if ( ! $this->handleOnContentPrepare($area, $context, $article, $params, $page))
		{
			return false;
		}

		Article::process($article, $context, $this, 'processArticle', [$area, $context, $article, $page]);

		return true;
	}

	/**
	 * @param JForm $form The form to be altered.
	 * @param mixed $data The associated data for the form.
	 *
	 * @return  bool
	 */
	public function onContentPrepareForm(JForm $form, $data)
	{
		if ( ! $this->passChecks())
		{
			return true;
		}

		return $this->handleOnContentPrepareForm($form, $data);
	}

	/**
	 * @return  void
	 */
	public function onAfterRender()
	{
		if ( ! $this->passChecks())
		{
			return;
		}

		$this->handleOnAfterRender();

		$html = $this->app->getBody();

		if ($html == '')
		{
			return;
		}

		if ( ! $this->changeFinalHtmlOutput($html))
		{
			return;
		}

		$this->cleanFinalHtmlOutput($html);

		$this->app->setBody($html);
	}

	/**
	 * @return  void
	 */
	protected function handleOnAfterRoute()
	{
	}

	/**
	 * @return  void
	 */
	protected function handleOnAfterDispatch()
	{
	}

	/**
	 * @return  void
	 */
	protected function handleOnAfterInitialise()
	{
	}

	/**
	 * @param string    $area
	 * @param string    $context The context of the content being passed to the plugin.
	 * @param mixed     $article An object with a "text" property
	 * @param mixed    &$params  Additional parameters. See {@see PlgContentContent()}.
	 * @param int       $page    Optional page number. Unused. Defaults to zero.
	 *
	 * @return  bool
	 */
	protected function handleOnContentPrepare($area, $context, &$article, &$params, $page = 0)
	{
		return true;
	}

	/**
	 * @param JForm $form The form to be altered.
	 * @param mixed $data The associated data for the form.
	 *
	 * @return  bool
	 */
	protected function handleOnContentPrepareForm(JForm $form, $data)
	{
		return true;
	}

	/**
	 * @param string $buffer
	 *
	 * @return  void
	 */
	protected function loadStylesAndScripts(&$buffer)
	{
	}

	/**
	 * @return  void
	 *
	 * Consider using changeFinalHtmlOutput instead
	 */
	protected function handleOnAfterRender()
	{
	}

	/**
	 * @param string &$string
	 * @param string  $area
	 * @param string  $context The context of the content being passed to the plugin.
	 * @param mixed   $article An object with a "text" property
	 * @param int     $page    Optional page number. Unused. Defaults to zero.
	 *
	 * @return  void
	 */
	public function processArticle(&$string, $area = 'article', $context = '', $article = null, $page = 0)
	{
	}

	/**
	 * @param string $buffer
	 *
	 * @return  bool
	 */
	protected function changeDocumentBuffer(&$buffer)
	{
		return false;
	}

	/**
	 * @param string $html
	 *
	 * @return  bool
	 */
	protected function changeFinalHtmlOutput(&$html)
	{
		return false;
	}

	/**
	 * @param string $html
	 *
	 * @return  void
	 */
	protected function cleanFinalHtmlOutput(&$html)
	{
	}

	/**
	 * @return  bool
	 */
	protected function passChecks()
	{
		if ( ! is_null($this->_pass))
		{
			return $this->_pass;
		}

		$this->_pass = false;

		if ( ! $this->isFrameworkEnabled())
		{
			return false;
		}

		if ( ! $this->passPageTypes())
		{
			return false;
		}

		// allow in frontend?
		if ( ! $this->_enable_in_frontend
			&& ! $this->_is_admin)
		{
			return false;
		}

		$params = Parameters::getInstance()->getPluginParams($this->_name);

		// allow in admin?
		if ( ! $this->_enable_in_admin
			&& $this->_is_admin
			&& ( ! isset($params->enable_admin) || ! $params->enable_admin))
		{
			return false;
		}

		// disabled by url?
		if ($this->_can_disable_by_url
			&& Protect::isDisabledByUrl($this->_alias))
		{
			return false;
		}

		// disabled by component?
		if ($this->_disable_on_components
			&& Protect::isRestrictedComponent(isset($params->disabled_components) ? $params->disabled_components : [], 'component'))
		{
			return false;
		}

		// restricted page?
		if (Protect::isRestrictedPage($this->_has_tags, $this->_protected_formats))
		{
			return false;
		}

		if ( ! $this->extraChecks())
		{
			return false;
		}

		$this->_pass = true;

		return true;
	}

	protected function passPageTypes()
	{
		if (empty($this->_page_types))
		{
			return true;
		}

		if (in_array('*', $this->_page_types))
		{
			return true;
		}

		if (empty(JFactory::$document))
		{
			return true;
		}

		if (Document::isFeed())
		{
			return in_array('feed', $this->_page_types);
		}

		if (Document::isPDF())
		{
			return in_array('pdf', $this->_page_types);
		}

		$page_type = JFactory::getDocument()->getType();

		if (in_array($page_type, $this->_page_types))
		{
			return true;
		}

		return false;
	}

	protected function extraChecks()
	{
		$input = JFactory::getApplication()->input;

		// Disable on Gridbox edit form: option=com_gridbox&view=gridbox
		if ($input->get('option') == 'com_gridbox' && $input->get('view') == 'gridbox')
		{
			return false;
		}

		// Disable on SP PageBuilder edit form: option=com_sppagebuilder&view=form
		if ($input->get('option') == 'com_sppagebuilder' && $input->get('view') == 'form')
		{
			return false;
		}

		return true;
	}

	protected function init()
	{
		return;
	}

	/**
	 * Check if the Regular Labs Library is enabled
	 *
	 * @return bool
	 */
	private function isFrameworkEnabled()
	{
		if ( ! defined('REGULAR_LABS_LIBRARY_ENABLED'))
		{
			$this->setIsFrameworkEnabled();
		}

		if ( ! REGULAR_LABS_LIBRARY_ENABLED)
		{
			$this->throwError('REGULAR_LABS_LIBRARY_NOT_ENABLED');
		}

		return REGULAR_LABS_LIBRARY_ENABLED;
	}

	/**
	 * Set the define with whether the Regular Labs Library is enabled
	 */
	private function setIsFrameworkEnabled()
	{
		if ( ! JPluginHelper::isEnabled('system', 'regularlabs'))
		{
			$this->throwError('REGULAR_LABS_LIBRARY_NOT_ENABLED');

			define('REGULAR_LABS_LIBRARY_ENABLED', false);

			return;
		}

		define('REGULAR_LABS_LIBRARY_ENABLED', true);
	}

	/**
	 * Place an error in the message queue
	 */
	protected function throwError($error)
	{
		// Return if page is not an admin page or the admin login page
		if (
			! JFactory::getApplication()->isClient('administrator')
			|| JFactory::getUser()->get('guest')
		)
		{
			return;
		}

		// load the admin language file
		JFactory::getLanguage()->load('plg_' . $this->_type . '_' . $this->_name, JPATH_PLUGINS . '/' . $this->_type . '/' . $this->_name);

		$text = JText::sprintf($this->_lang_prefix . '_' . $error, JText::_($this->_title));
		$text = JText::_($text) . ' ' . JText::sprintf($this->_lang_prefix . '_EXTENSION_CAN_NOT_FUNCTION', JText::_($this->_title));

		// Check if message is not already in queue
		$messagequeue = JFactory::getApplication()->getMessageQueue();
		foreach ($messagequeue as $message)
		{
			if ($message['message'] == $text)
			{
				return;
			}
		}

		JFactory::getApplication()->enqueueMessage($text, 'error');
	}
}

