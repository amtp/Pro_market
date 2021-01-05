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
<?php $dir = opendir(''.JPATH_BASE.'/images/dostoprimechatelnosti/'.$item_id.'');
	$count_photo = 0;
	while($file = readdir($dir)){
	if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/dostoprimechatelnosti/'.$item_id.'' . $file)){
		continue;
	}
	$count_photo++;
} ?>
<div class="katalog_item padding <?php if($this->item->featured) { ?>cool<?php }?>" >
<?php if($count_photo > 0) { ?>
	<div class="mod_news_img">
		<a href="<?php echo $link?>#link" title="<?php echo $this->item->title ?>"><span class="podlozhka"></span></a>
		<?php echo JHtml::_('content.prepare', '{gallery preview-width=255 preview-height=170}dostoprimechatelnosti/'.$item_id.'{/gallery}'); ?>
	</div>
<?php } else { ?>
	<div class="old_mod_news_img">
		<a href="<?php echo $link?>#link" title="<?php echo $this->item->title ?>"><img class="lazy" src="<?php echo $img ?>" alt="<?php echo $item->title ?>" /></a>
	</div><?php } ?><div class="kat_item_info">
	<h3>
		<a href="<?php echo $link?>#link" title="<?php echo $this->item->title ?>">
			<?php echo $this->item->title ?>
		</a>
	</h3>
	<div class="mini_icons">
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
		<div class="ic_cat">
			<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catid)); ?>" title="<?php echo $this->item->category_title ?>">
			<?php echo $this->item->category_title ?>
			</a>
		</div>	
	</div>
	<div class="dost_icons">
		<div class="ic_cat">
			<i class="fa fa-map-marker"></i>
			<?php echo $f[67] ?>
		</div>
		<?php if($f[68]) { ?>
		<div class="ic_cat">
			<i class="fa fa-clock-o"></i>
			<?php echo $f[68] ?>
		</div>	
		<?php } ?>
		<?php if($f[69]) { ?>
		<div class="ic_big_phone">
			<i class="fa fa-mobile"></i>
			<?php echo $f[69] ?>
		</div>	
		<?php } ?>		
	</div>
	
</div>
</div>