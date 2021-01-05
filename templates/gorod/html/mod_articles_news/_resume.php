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
<?php $dir = opendir(''.JPATH_BASE.'/images/resume/'.$item_id.'');
	$count_photo = 0;
	while($file = readdir($dir)){
	if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/resume/'.$item_id.'' . $file)){
		continue;
	}
	$count_photo++;
} ?>
<?php if($count_photo > 0) { ?>
	<div class="mod_news_img">
		<a href="<?php echo $item->link ?>" title="<?php echo $item->title ?>"><span class="podlozhka"></span></a>
		<?php echo JHtml::_('content.prepare', '{gallery preview-width=100 preview-height=80}resume/'.$item_id.'{/gallery}'); ?>
	</div>
<?php } else { ?>
	<?php if($img == '/images/resume/') { ?>
		<div class="mod_news_img">
			<a href="<?php echo $item->link ?>" title="<?php echo $item->title ?>"><span class="podlozhka"></span></a>
			<?php echo JHtml::_('content.prepare', '{gallery preview-width=100 preview-height=80}no_images{/gallery}'); ?>
		</div>	
	<?php } else { ?>
		<div class="old_mod_news_img">
			<a href="<?php echo $item->link ?>" title="<?php echo $item->title ?>"><img class="lazy" src="<?php echo $img ?>" alt="<?php echo $item->title ?>" /></a>
		</div>
	<?php } ?>
<?php } ?>
	<div class="mod_info_blog">
	<div class="news_caption">
		<h3><a href="<?php echo $item->link ?>" title="<?php echo $item->title ?>"><?php echo $item->title ?></a></h3>
	</div>	
		<div class="mini_icon">
			<div class="ic"><i class="fa fa-calendar-check-o"></i> <span><?php echo JHTML::_('date', $item->created , JText::_('DATE_FORMAT_LC1')); ?></span></div>
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
			<div class="ic"><i class="fa fa-mortar-board"></i> <span><?php echo $f[28] ?></span></div
			><div class="ic"><i class="fa fa-clock-o"></i> <span><?php echo $f[30] ?></span></div>
		</div>
		<div class="work_price"><span><?php echo number_format($f[27],0,'',' ') ?> <?php echo $valuta1 ?></span></div>
	</div>



