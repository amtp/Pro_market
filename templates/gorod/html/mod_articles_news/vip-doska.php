<?php defined('_JEXEC') or die ?>
<div class="newsflash">
	
<?php
foreach ($list as $key => $item) { ?>
	<div class="mini-blogs">
		<?php require JModuleHelper::getLayoutPath('mod_articles_news', '_vip-doska'); ?>
	</div>
<?php } ?>

</div>
