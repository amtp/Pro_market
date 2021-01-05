<?php defined('_JEXEC') or die ?>
<div class="newsflash <?php echo $moduleclass_sfx; ?>">
<div class="mini_menu">
	<?php echo JHtml::_('content.prepare', '{loadposition home_auto,none}'); ?>
</div>
<div class="carousel shadow"> 
    <div class="carousel-button-left"><a href="#"><i class="fa fa-angle-left" aria-hidden="true"></i></a></div> 
    <div class="carousel-button-right"><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i></a></div> 
<div class="carousel-wrapper"> 
<div class="carousel-items"> 	
<?php
	foreach ($list as $key => $item) { ?>
	<div class="carousel-block">
		<div class="padding">
			<?php require JModuleHelper::getLayoutPath('mod_articles_news', '_car'); ?>
		</div>
	</div>
<?php } ?>

</div>
</div>
</div>
</div>