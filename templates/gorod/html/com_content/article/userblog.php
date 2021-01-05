<?php
defined('_JEXEC') or die;
$item_id = $this->item->id;


JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
$images = json_decode($this->item->images);
$user = JFactory::getUser();
require_once JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/rsform.php';

$app = JFactory::getApplication();
$template = $app->getTemplate(true);
$ya_knopki = $template->params->get('ya_knopki', '');

$domen = JUri::base();

foreach($this->item->jcfields as $field) { 
		$f[$field->id] = $field->value;
	}
	
$user_id = $this->item->created_by;
$db = JFactory::getDbo();
$db->setQuery("SELECT `avatar` FROM #__plg_slogin_profile WHERE user_id = '$user_id'");
$avatar = $db->loadResult();	
?>
<div class="news_all <?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Article">
	<?php if($user->id == $this->item->created_by) { ?>
		<div class="panel_left">
			<div class="edit_button">
				<a href="#edit"><i class="fa fa-pencil-square-o"></i> Редактировать</a>
			</div>
			<div class="delete_button">
				<a href="#delete"><i class="fa fa-trash-o"></i> Удалить</a>
			</div>
		</div>
	<?php } ?>
<?php if($this->item->featured)	{ ?>
	<div class="featured">
		<span class="fa-stack fa-lg">
		<i class="fa fa-thumbs-o-up fa-stack-1x"></i>
		<i class="fa fa-circle-o-notch fa-spin fa-stack-2x"></i>
		</span>
		<span>Мы рекомендуем</span>
	</div>
<?php } ?>
	<meta itemprop="inLanguage" content="<?php echo ($this->item->language === '*') ? JFactory::getConfig()->get('language') : $this->item->language; ?>" />
	<h1 itemprop="headline">
		<?php echo $this->escape($this->item->title); ?>
	</h1>
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
		<div class="ic_cat">
			<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catid)); ?>" title="<?php echo $this->item->category_title ?>">
			<?php echo $this->item->category_title ?>
			</a>
			
		</div>	
	</div>
	<div class="news_logo_block">
		<?php if($avatar) { ?>
		<div class="mini_avatar">
			<div class="mini_avatar_block">
				<img src="/images/avatar/<?php echo $avatar ?>" alt="" />
			</div>
		</div>
		<?php } ?>
		<div class="bloger">
			<?php echo $this->item->author ?>
		</div>
	<div class="news_logo">
			<?php $dir = opendir(''.JPATH_BASE.'/images/blog/'.$item_id.'');
				$count_photo = 0;
				while($file = readdir($dir)){
				if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/blog/'.$item_id.'' . $file)){
					continue;
				}
				$count_photo++;
			} ?>
		<?php if($count_photo > 0) { ?>
			<?php echo JHtml::_('content.prepare', '{gallery preview-width=450 preview-height=350}blog/'.$item_id.'{/gallery}'); ?>
		<?php } else { ?>
			<img class="lazy" src="<?php echo $images->image_intro ?>"/>
		<?php } ?>
	</div>
	</div>
		<?php if($ya_knopki == '1') { ?>
			<div class="social_button no_link">
				<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
				<script src="//yastatic.net/share2/share.js"></script>
				<div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir,gplus" data-counter="" data-image="<?php echo $domen;?><?php echo $images->image_intro;?>" data-description='<?php echo $this->item->fulltext?>'></div>	
			</div>
		<?php } ?>		
	<div class="intro_text_item">
		<?php echo JHtml::_('content.prepare', $this->item->introtext); ?>
	</div>	

<?php if($f[74]) { ?>
<div class="gallery">	
			<?php $dir = opendir(''.JPATH_BASE.'/images/gallery/'.$item_id.'');
				$count_gallery = 0;
				while($file = readdir($dir)){
				if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/gallery/'.$item_id.'' . $file)){
					continue;
				}
				$count_gallery++;
			} ?>
<?php if($count_gallery > 0) { ?>
	<?php echo JHtml::_('content.prepare', '{gallery preview-width=210 preview-height=150}gallery/'.$item_id.'{/gallery}'); ?>
<?php } ?>
</div>
<?php } ?>	
	
	<div class="desc">
		<?php echo JHtml::_('content.prepare', $this->item->fulltext); ?>
	</div>	

<div class="col3">
<h4><i class="fa fa-comments"></i> Отзывы</h4>
</div>
	<?php
		$comments = JPATH_ROOT . '/components/com_jcomments/jcomments.php';
		if (file_exists($comments)) {
		require_once($comments);
		echo JComments::showComments($this->item->id, 'com_content', $this->item->title);
		}
	?>
</div>

