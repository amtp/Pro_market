<?php
defined('_JEXEC') or die ();

class plgKunenaSlogin extends JPlugin
{
	public function __construct(&$subject, $config)
	{
		if (!(class_exists('KunenaForum') && KunenaForum::isCompatible('4.0') && KunenaForum::installed()))
		{
			return;
		}

		parent::__construct($subject, $config);
	}


	public function onKunenaGetAvatar()
	{
		if (!$this->params->get('avatar', 1))
		{
			return null;
		}
		require_once __DIR__ . '/avatar.php';

		return new KunenaAvatarSlogin($this->params);
	}
}
