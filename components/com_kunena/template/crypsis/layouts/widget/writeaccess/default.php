<?php
/**
 * Kunena Component
 * @package         Kunena.Template.Crypsis
 * @subpackage      Layout.Widget
 *
 * @copyright       Copyright (C) 2008 - 2018 Kunena Team. All rights reserved.
 * @license         https://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link            https://www.kunena.org
 **/
defined('_JEXEC') or die;
use Joomla\CMS\Language\Text;

$topic  = KunenaForumTopicHelper::get($this->id);
$config = KunenaFactory::getConfig();
?>

<div class="kfrontend">
	<div class="btn-toolbar pull-right">
		<div class="btn-group">
			<div class="btn btn-small" data-toggle="collapse" data-target="#writeaccess"></div>
		</div>
	</div>

	<h3 class="btn-link">
		<?php echo Text::_('COM_KUNENA_WRITEACCESS'); ?>
	</h3>

	<div class="row-fluid collapse in" id="writeaccess">
		<div class="well-small">
			<ul class="unstyled span6">
				<li>
					<?php if ($topic->getCategory()->getNewTopicCategory()->exists())
					{ ?>
						<b><?php echo Text::_('COM_KUNENA_ACCESS_ALLOWED'); ?></b> <?php echo Text::_('COM_KUNENA_ACCESS_ALLOWED_CREATETOPIC'); ?>
					<?php }
					else
					{ ?>
						<b><?php echo Text::_('COM_KUNENA_ACCESS_NOTALLOWED'); ?></b> <?php echo Text::_('COM_KUNENA_ACCESS_ALLOWED_CREATETOPIC'); ?>
					<?php } ?>
				</li>
				<li>
					<?php if ($topic->isAuthorised('reply'))
					{ ?>
						<b><?php echo Text::_('COM_KUNENA_ACCESS_ALLOWED'); ?></b> <?php echo Text::_('COM_KUNENA_ACCESS_ALLOWED_REPLY'); ?>
					<?php }
					else
					{ ?>
						<b><?php echo Text::_('COM_KUNENA_ACCESS_NOTALLOWED'); ?></b> <?php echo Text::_('COM_KUNENA_ACCESS_ALLOWED_REPLY'); ?>
					<?php } ?>
				</li>
				<li>
					<?php if ($topic->isAuthorised('reply') && $config->file_upload !== 'nobody' || $topic->isAuthorised('reply') && $config->file_upload = 'everybody')
					{ ?>
						<b><?php echo Text::_('COM_KUNENA_ACCESS_ALLOWED'); ?></b> <?php echo Text::_('COM_KUNENA_ACCESS_ALLOWED_ADDATTACH'); ?>
					<?php }
					else
					{ ?>
						<b><?php echo Text::_('COM_KUNENA_ACCESS_NOTALLOWED'); ?></b> <?php echo Text::_('COM_KUNENA_ACCESS_ALLOWED_ADDATTACH'); ?>
					<?php } ?>
				</li>
				<li>
					<?php if ($topic->isAuthorised('edit'))
					{ ?>
						<b><?php echo Text::_('COM_KUNENA_ACCESS_ALLOWED'); ?></b> <?php echo Text::_('COM_KUNENA_ACCESS_ALLOWED_EDITPOST'); ?>
					<?php }
					else
					{ ?>
						<b><?php echo Text::_('COM_KUNENA_ACCESS_NOTALLOWED'); ?></b> <?php echo Text::_('COM_KUNENA_ACCESS_ALLOWED_EDITPOST'); ?>
					<?php } ?>
				</li>
			</ul>
		</div>
	</div>
</div>
