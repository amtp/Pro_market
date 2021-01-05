<?php defined('_JEXEC') or die;
$params = $this->item->params;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
$uri = JFactory::getURI();
$domen = $uri->toString(array('host'));

$item_id = $this->item->id;
$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
$img = json_decode($this->item->images)->image_intro;
foreach($this->item->jcfields as $field) { 
	$f[$field->id] = $field->value;
}

$user = JFactory::getUser();	

?>

<div class="padding">
	<div class="mod_afisha_img">
		<a href="<?php echo $link?>#link" title="<?php echo $this->item->title ?>"><span class="podlozhka"></span></a>
		<?php echo JHtml::_('content.prepare', '{gallery preview-width=220 preview-height=330}photo/uchastniki/'.$item_id.'{/gallery}'); ?>
	</div>
<div class="afisha_item_info">
	<h3>
		<a href="<?php echo $link?>#link" title="<?php echo $this->item->title ?>">
			<span><?php echo $this->item->title ?></span>
		</a>
	</h3>
</div>
		<div class="social">
			<div class="ya-share2" data-counter="" data-size="s" data-title="<?php echo $this->item->title ?>" data-url="http://<?php echo $domen ?><?php echo $link?>" data-services="vkontakte,odnoklassniki,facebook,moimir" data-image="http://<?php echo $domen ?>/<?php echo $img ?>" ></div>		
		</div>		
		<div class="mini_icon">
			<div class="ic"><i class="fa fa-eye"></i> <span><?php echo $this->item->hits ?></span></div>
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
		</div>
		<div class="mod_cat">
			<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catid)); ?>" title="<?php echo $this->item->category_title ?>">
				<?php echo $this->item->category_title ?>
			</a>
		</div>
</div>

