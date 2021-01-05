<?php
/**
 * Kunena Plugin
 *
 * @package       Kunena.Plugins
 * @subpackage    Gravatar
 *
 * @copyright (C) 2008 - 2016 Kunena Team. All rights reserved.
 * @license       http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link          https://www.kunena.org
 **/
defined('_JEXEC') or die ();

class KunenaAvatarslogin extends KunenaAvatar
{
	protected $params = null;

	/**
	 * @param $params
	 */
	public function __construct($params)
	{
		$this->params = $params;
		$this->resize = true;
	}
	

	/**
	 * @return bool
	 */
	public function getEditURL()
	{
		return KunenaRoute::_('index.php?option=com_kunena&view=user&layout=edit');
	}

	/**
	 * @param $user
	 * @param $sizex
	 * @param $sizey
	 *
	 * @return string
	 */
	protected function _getURL($user, $sizex, $sizey)
	{
		$user   = KunenaFactory::getUser($user);
		$avatar = $user->avatar;
		$config = KunenaFactory::getConfig();

		$path     = KPATH_MEDIA . "/avatars";
		$origPath = "{$path}/{$avatar}";

		if (!is_file($origPath))
		{
			// If avatar does not exist use default image.
			if ($sizex <= 90)
			{
				$avatar = 's_nophoto.jpg';
			}
			else
			{
				$avatar = 'nophoto.jpg';
			}

			// Search from the template.
			$template = KunenaFactory::getTemplate();
			$origPath = JPATH_SITE . '/' . $template->getAvatarPath($avatar);
			$avatar   = $template->name . '/' . $avatar;
			
		}
		$dir  = dirname($avatar);
		$file = basename($avatar);

		if ($sizex == $sizey)
		{
			$resized = "resized/size{$sizex}/{$dir}";
		}
		else
		{
			$resized = "resized/size{$sizex}x{$sizey}/{$dir}";
		}

		// TODO: make timestamp configurable?
		$timestamp = '';

		if (!is_file("{$path}/{$resized}/{$file}"))
		{
			KunenaImageHelper::version($origPath, "{$path}/{$resized}", $file, $sizex, $sizey, intval($config->avatarquality), KunenaImage::SCALE_INSIDE, intval($config->avatarcrop));
			$timestamp = '?' . round(microtime(true));
		}
		if (strpos($file, 'nophoto') !== false) {
		
		if(JPluginHelper::isEnabled('slogin_integration', 'profile') && $user->id > 0){
        require_once JPATH_SITE.'/plugins/slogin_integration/profile/helper.php';
        $profile = plgProfileHelper::getProfile($user->id);
        $av_slog = isset($profile->avatar) ? $profile->avatar : '';
    }

		return $av_slog;
}else{return KURL_MEDIA . "avatars/{$resized}/{$file}{$timestamp}";}
	}
	//
		
	
}
