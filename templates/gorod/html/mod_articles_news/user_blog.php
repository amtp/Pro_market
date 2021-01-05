<?php defined('_JEXEC') or die ?>
<div class="newsflash <?php echo $moduleclass_sfx; ?>">
	
<?php
foreach ($list as $key => $item) { ?>
	<div class="mini-blogs">
		<?php require JModuleHelper::getLayoutPath('mod_articles_news', '_userblog'); ?>
	</div>
<?php } ?>

</div>
