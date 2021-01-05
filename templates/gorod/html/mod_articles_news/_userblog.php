<?php defined('_JEXEC') or die;
$item_id = $item->id;
$img = json_decode($item->images)->image_intro;

$user = JFactory::getUser();
$db = JFactory::getDbo();

$user_id = $item->created_by; 
$db->setQuery("SELECT `avatar` FROM #__plg_slogin_profile WHERE user_id = '$user_id'");
$avatar = $db->loadResult();
?>
<?php $dir = opendir(''.JPATH_BASE.'/images/blog/'.$item_id.'');
	$count_photo = 0;
	while($file = readdir($dir)){
	if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/blog/'.$item_id.'' . $file)){
		continue;
	}
	$count_photo++;
} ?>
<?php if($count_photo > 0) { ?>
	<div class="mod_news_img">
		<a href="<?php echo $item->link ?>" title="<?php echo $item->title ?>"><span class="podlozhka"></span></a>
		<?php echo JHtml::_('content.prepare', '{gallery preview-width=100 preview-height=84}blog/'.$item_id.'{/gallery}'); ?>
	</div>
<?php } else { ?>
	<div class="old_mod_news_img">
		<a href="<?php echo $item->link ?>" title="<?php echo $item->title ?>"><img class="lazy" src="<?php echo $img ?>" alt="<?php echo $item->title ?>" /></a>
	</div>
<?php } ?>
	<div class="mod_info_blog">
	<div class="news_caption">
		<h3><a href="<?php echo $item->link ?>" title="<?php echo $item->title ?>"><?php echo $item->title ?></a></h3>
	</div>	
		<div class="text_userblog">
			<div class="userblog_avatar">
				<?php if($avatar) { ?>
					<img src="/images/avatar/<?php echo $avatar ?>" />
				<?php } else { ?>
					<img src="/images/avatar/no_avatar.jpg" />
				<?php } ?>
			</div>
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
			<div class="name_user_blog">
				<span><?php echo $item->author ?></span>
			</div>
		</div>
		<div class="ic_cat">
			<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->catid)); ?>" title="<?php echo $item->category_title ?>">
			<?php echo $item->category_title ?>
			</a>
		</div>
	</div>	
<div class="user_blog_intro">
	<?php echo strip_tags(mb_substr($item->introtext, 0, 150, 'UTF-8') . '...'); ?>
		<a class="readmore" href="<?php echo $item->link; ?>">Далее <i class="fa fa-angle-double-right"></i></a>
</div>	