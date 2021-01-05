<?php
defined('_JEXEC') or die;
$item_id = $this->item->id;

$params = $this->item->params;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
$img = json_decode($this->item->images)->image_intro;
$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
foreach($this->item->jcfields as $field) { 
		$f[$field->id] = $field->value;
	}
?>
<?php $dir = opendir(''.JPATH_BASE.'/images/problem/'.$item_id.'');
	$count_photo = 0;
	while($file = readdir($dir)){
	if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/problem/'.$item_id.'' . $file)){
		continue;
	}
	$count_photo++;
} ?>
<div class="katalog_item<?php if($this->item->featured) { ?>cool<?php }?>" >
<?php if($count_photo > 0) { ?>
	<div class="mod_news_img">
		<div class="problem_img"><div class="problem_status"><?php echo $f[107] ?></div>
		<a href="<?php echo $link?>#link" title="<?php echo $this->item->title ?>"><span class="podlozhka"></span></a>
		<?php echo JHtml::_('content.prepare', '{gallery preview-width=255 preview-height=170}problem/'.$item_id.'{/gallery}'); ?>
		</div>
	</div>
<?php } else { ?>
	<div class="mod_news_img">
		<div class="problem_img"><div class="problem_status"><?php echo $f[107] ?></div>
		<a href="<?php echo $link?>#link" title="<?php echo $this->item->title ?>"><span class="podlozhka"></span></a>
		<?php echo JHtml::_('content.prepare', '{gallery preview-width=255 preview-height=170}no_images{/gallery}'); ?>
		</div>
	</div><?php } ?><div class="kat_item_info">
	<h3>
		<a href="<?php echo $link?>#link" title="<?php echo $this->item->title ?>">
			<?php echo $this->item->title ?>
		</a>
	</h3>
	<div class="mini_icons">
		<div class="ic">
			<i class="fa fa-calendar-check-o"></i>
			<?php echo JHTML::_('date', $this->item->created , JText::_('DATE_FORMAT_LC2')); ?>
		</div>
		<div class="ic">
			<i class="fa fa-eye"></i>
			<?php echo $this->item->hits ?>
		</div>
		<div class="ic">
			<i class="fa fa-comments"></i>
				<?php
					$comments = JPATH_SITE . '/components/com_jcomments/jcomments.php';
					if (file_exists($comments)) {
					require_once($comments);
					$options = array();
					$options['object_id'] = $this->item->id;
					$options['object_group'] = 'com_content';
					$options['published'] = 1;
					$count = JCommentsModel::getCommentsCount($options);
					echo $count ? ''. $count . '' : '0';
				} ?>
		</div>	
		<div class="ic problem_cat">
			<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catid)); ?>" title="<?php echo $this->item->category_title ?>">
			<?php echo $this->item->category_title ?>
			</a>
		</div>	
	</div>
<div class="intro_text">
	<?php echo $this->item->introtext ?>
</div>	
</div>
</div>