<?php defined('_JEXEC') or die;
$item_id = $item->id;
$img = json_decode($item->images)->image_intro;
foreach($item->jcfields as $field) { 
	$f[$field->id] = $field->value;
}
$user = JFactory::getUser();	
$app = JFactory::getApplication();
$templ = $app->getTemplate(true);	
$rating_user = $templ->params->get('rating_user', '');
?>
<?php $dir = opendir(''.JPATH_BASE.'/images/katalog/'.$item_id.'');
	$count_photo = 0;
	while($file = readdir($dir)){
	if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/katalog/'.$item_id.'' . $file)){
		continue;
	}
	$count_photo++;
} ?>
<?php if($count_photo > 0) { ?>
	<div class="mod_news_img">
		<a href="<?php echo $item->link ?>" title="<?php echo $item->title ?>"><span class="podlozhka"></span></a>
		<?php echo JHtml::_('content.prepare', '{gallery preview-width=230 preview-height=165}katalog/'.$item_id.'{/gallery}'); ?>
	</div>
<?php } else { ?>
	<div class="old_mod_news_img">
		<a href="<?php echo $item->link ?>" title="<?php echo $item->title ?>"><img class="lazy" src="<?php echo $img ?>" alt="<?php echo $item->title ?>" /></a>
	</div>
<?php } ?>	
	<div class="news_caption">
		<h3><a href="<?php echo $item->link ?>" title="<?php echo $item->title ?>"><?php echo $item->title ?></a></h3>
	</div>	
		<div class="mini_icon">
			<div class="ic"><i class="fa fa-eye"></i> <span><?php echo $item->hits ?></span></div>
			<div class="ic">
				<i class="fa fa-comments"></i>
					<?php
					$comments = JPATH_SITE . '/components/com_jcomments/jcomments.php';
					if (file_exists($comments)) {
					require_once($comments);
					$options = array();
					$options['object_id'] = $item->id;
					$options['object_group'] = 'com_content';
					$options['published'] = 1;
					$count = JCommentsModel::getCommentsCount($options);
					echo $count ? ''. $count . '' : '0';
				} ?>
			</div>	
			<div class="ic">
				<?php if($rating_user == '0') { ?>
					<?php JPluginHelper::importPlugin( 'content', 'vrvote' ); $dispatcher = JDispatcher::getInstance(); $results = $dispatcher->trigger( 'vrvote', $item->id ); ?>
				<?php } else { ?>
				<?php if($user->guest) { ?>
					<span class="no_rating">
						<a class="no_link" href="#login"></a>
						<?php JPluginHelper::importPlugin( 'content', 'vrvote' ); $dispatcher = JDispatcher::getInstance(); $results = $dispatcher->trigger( 'vrvote', $item->id ); ?>
					</span>
					<?php } else { ?>
						<?php JPluginHelper::importPlugin( 'content', 'vrvote' ); $dispatcher = JDispatcher::getInstance(); $results = $dispatcher->trigger( 'vrvote', $item->id ); ?>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
		<div class="mod_cat">
			<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->catid)); ?>" title="<?php echo $item->category_title ?>">
				<?php echo $item->category_title ?>
			</a>
		</div>
	<div class="mod_info">
		<?php if($f[1]) { ?>
		<div class="ic">
			<i class="fa fa-map-marker"></i>
			<?php echo $f[1] ?>
		</div>
		<?php } ?>
		<?php if($f[5]) { ?>
		<div class="ic">
			<i class="fa fa-clock-o"></i>
			<?php echo $f[5] ?>
		</div>
		<?php } ?>
	</div>	


