<?php defined('_JEXEC') or die ?>
<div class="newsflash <?php echo $moduleclass_sfx; ?>">
	
<?php
foreach ($list as $key => $item) { ?>
	<div class="big">
		<?php require JModuleHelper::getLayoutPath('mod_articles_news', '_blogs'); ?>
	</div>
	<div class="new_reklam">
		<?php echo JHtml::_('content.prepare', '{loadposition blogs_home_reklam,none}'); ?>
	</div>
<?php } ?>

</div>
