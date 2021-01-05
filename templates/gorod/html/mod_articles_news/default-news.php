<?php defined('_JEXEC') or die ?>
<div class="newsflash <?php echo $moduleclass_sfx; ?>">
	
<?php
foreach ($list as $key => $item) { ?>
	<div class="big">
		<?php require JModuleHelper::getLayoutPath('mod_articles_news', '_news'); ?>
	</div>

<?php } ?>
<div class="carousel shadow"> 
    <div class="carousel-button-left"><a href="#"><i class="fa fa-angle-left" aria-hidden="true"></i></a></div> 
    <div class="carousel-button-right"><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i></a></div> 
	<div class="carousel-wrapper"> 
	<div class="carousel-items"> 

	</div>
	</div>
</div>
</div>
