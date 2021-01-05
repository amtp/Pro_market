<?php defined('_JEXEC') or die;
$item_id = $item->id;
$img = json_decode($item->images)->image_intro;
foreach($item->jcfields as $field) { 
	$f[$field->id] = $field->value;
}
$app = JFactory::getApplication();
$templ = $app->getTemplate(true);
$valuta1 = $templ->params->get('valuta', '');
?>
<?php $dir = opendir(''.JPATH_BASE.'/images/doska/'.$item_id.'');
	$count_photo = 0;
	while($file = readdir($dir)){
	if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/doska/'.$item_id.'' . $file)){
		continue;
	}
	$count_photo++;
} ?>
<?php if($count_photo > 0) { ?>
	<div class="mod_news_img">
		<a href="<?php echo $item->link ?>" title="<?php echo $item->title ?>"><span class="podlozhka"></span></a>
		<?php echo JHtml::_('content.prepare', '{gallery preview-width=230 preview-height=165}doska/'.$item_id.'{/gallery}'); ?>
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
			<div class="ic">
				<i class="fa fa-calendar-check-o"></i>
				<?php echo JHTML::_('date', $item->created , JText::_('DATE_FORMAT_LC1')); ?>
			</div>			
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
		</div>
		<div class="mod_cat">
			<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->catid)); ?>" title="<?php echo $item->category_title ?>">
				<?php echo $item->category_title ?>
			</a>
		</div>
	<div class="mod_info">
		<div class="price">
			<?php echo number_format($f[79],0,'',' ') ?> <?php echo $valuta1 ?>
			<?php if($f[82] == 'Да') { ?>
				<sup>
					возможен торг
				</sup>
			<?php } ?>		
		</div>
	</div>	



