<?php
defined('_JEXEC') or die;
use Joomla\Registry\Registry;
JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');
$authorised = JFactory::getUser()->getAuthorisedViewLevels();

$item_id = $this->item->id;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
$images = json_decode($this->item->images);
$url = json_decode($this->item->urls);
$user = JFactory::getUser();
require_once JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/rsform.php';

$app = JFactory::getApplication();
$template = $app->getTemplate(true);
$ya_knopki = $template->params->get('ya_knopki', '');

$domen = JUri::base();

foreach($this->item->jcfields as $field) { 
		$f[$field->id] = $field->value;
	}
?>
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
<div class="news_all <?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Article">
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
			<ul class="tags inline">
				<?php foreach ($this->item->tags->itemTags as $i => $tag) : ?>
					<?php if (in_array($tag->access, $authorised)) : ?>
						<?php $tagParams = new Registry($tag->params); ?>
						<?php $link_class = $tagParams->get('tag_link_class', 'label label-info'); ?>
						<li class="tag-<?php echo $tag->tag_id; ?> tag-list<?php echo $i; ?>" itemprop="keywords">
							<a href="<?php echo JRoute::_(TagsHelperRoute::getTagRoute($tag->tag_id . '-' . $tag->alias)); ?>" class="<?php echo $link_class; ?>">
								<span class="fa fa-hashtag"></span> <?php echo $this->escape($tag->title); ?>
							</a>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>				
		</div>	
	</div>
	<div class="news_logo_block">
	<div class="news_logo">
			<?php $dir = opendir(''.JPATH_BASE.'/images/news/'.$item_id.'');
				$count_photo = 0;
				while($file = readdir($dir)){
				if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/news/'.$item_id.'' . $file)){
					continue;
				}
				$count_photo++;
			} ?>
		<?php if($count_photo > 0) { ?>
			<?php echo JHtml::_('content.prepare', '{gallery preview-width=450 preview-height=350}news/'.$item_id.'{/gallery}'); ?>
		<?php } else { ?>
			<img class="lazy" src="<?php echo $images->image_intro ?>"/>
		<?php } ?>
	</div>
	</div>
	<?php if($images->image_intro_alt) { ?>
	<div class="author_photo">
		<span><?php echo $images->image_intro_alt ?></span>
	</div>
	<?php } ?>
		<?php if($ya_knopki == '1') { ?>
			<div class="social_button no_link">
				<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
				<script src="//yastatic.net/share2/share.js"></script>
				<div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir,gplus" data-counter="" data-image="<?php echo $domen;?><?php echo $images->image_intro;?>" data-description=''></div>	
			</div>
		<?php } ?>		
	<div class="intro_text_item">
		<?php echo JHtml::_('content.prepare', $this->item->introtext); ?>
	</div>	
	<?php if($f[70]) { ?>
	<iframe width="100%" height="350" src="https://www.youtube.com/embed/<?php echo $f[70] ?>" frameborder="0" allowfullscreen></iframe>
	<?php } ?>
	<?php if($f[71]) { ?>
		<?php echo $f[71] ?>
	<?php } ?>


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

<div class="desc">
	<?php echo JHtml::_('content.prepare', $this->item->fulltext); ?>
</div>	
<?php if($url->urla) { ?>
<div class="istochnik">
Источник: <a href="<?php echo $url->urla ?>" title="<?php echo $url->urlatext ?>" target="_blank"><?php echo $url->urlatext ?></a>
</div>
<?php } ?>


<div class="other_news">
	<?php echo JHtml::_('content.prepare', '{loadposition other_news,top}'); ?>
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

<?php if($user->id == $this->item->created_by) { ?>
<a href="#x" class="overlay" id="edit"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('14'); // ФОРМА РЕДАКТИРОВАНИЯ СОБЫТИЯ ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>

<a href="#x" class="overlay" id="delete"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('15'); // ФОРМА УДАЛЕНИЯ СОБЫТИЯ ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>
<?php } ?>