<?php
defined('_JEXEC') or die;
require_once JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/rsform.php';
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
$images  = json_decode($this->item->images);
$user    = JFactory::getUser();
JHtml::_('behavior.caption');

$item_id = $this->item->id;

$app = JFactory::getApplication();
$template = $app->getTemplate(true);
$gorod = $template->params->get('gorod', '');
$ya_knopki = $template->params->get('ya_knopki', '');
$rating_user = $template->params->get('rating_user', '');

$domen = JUri::base();
?>


<div class="afisha <?php echo $this->pageclass_sfx; ?>">
	
	
	<h1 itemprop="headline">
		<?php echo $this->escape($this->item->header); ?>
	</h1>
	<div class="mini_icons">

		<div class="ic">
				<?php if($rating_user == '0') { ?>
					<?php JPluginHelper::importPlugin( 'content', 'vrvote' ); $dispatcher = JDispatcher::getInstance(); $results = $dispatcher->trigger( 'vrvote', $this->item->id ); ?>
				<?php } else { ?>
					<?php if($user->guest) { ?>
					<span class="no_rating">
						<a class="no_link" href="#login"></a>
						<?php JPluginHelper::importPlugin( 'content', 'vrvote' ); $dispatcher = JDispatcher::getInstance(); $results = $dispatcher->trigger( 'vrvote', $this->item->id ); ?>
					</span>
					<?php } else { ?>
						<?php JPluginHelper::importPlugin( 'content', 'vrvote' ); $dispatcher = JDispatcher::getInstance(); $results = $dispatcher->trigger( 'vrvote', $this->item->id ); ?>
					<?php } ?>
				<?php } ?>				
		</div>	
		<div class="ic_cat">
			<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catid)); ?>" title="<?php echo $this->item->category_title ?>">
			<?php echo $this->item->category_title ?>
			</a>
		</div>	
	</div>
	<div class="afisha_logo_block padding">
	
<?php if($count_photo > 0) { ?>
	<div class="mod_afisha_img">
		<?php echo JHtml::_('content.prepare', '{gallery preview-width=220 preview-height=330}afisha/'.$item_id.'{/gallery}'); ?>
	</div>
<?php } else { ?>
	<div class="old_mod_afisha_img">
		<a href="<?php echo $link?>" title="<?php echo $this->item->title ?>"><img class="lazy" src="<?php echo $img ?>" alt="<?php echo $this->item->title ?>" /></a>
	</div>
<?php } ?>	
	</div
	><div class="item_afisha_info">
	<?php if($ya_knopki == '1') { ?>
		<div class="social_button">
			<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
			<script src="//yastatic.net/share2/share.js"></script>
			<div class='ya-share2' data-services='vkontakte,facebook,odnoklassniki,moimir,gplus' data-counter='' data-image='<?php echo $domen ?><?php echo $images->image_intro;?>' data-description='<?php echo $this->item->fulltext?>'></div>
		</div>
	<?php } ?>
	<?php if($f[7]) { ?>
		<div class="ic_afisha">
			<span>Дата выхода:</span> <?php echo $f[7] ?> <?php echo $f[12] ?>
		</div>
	<?php } ?>
		<div class="realti_row"></div>
		<?php if($f[8]) { ?>
		<div class="ic_afisha">
			<span>Жанр:</span> <?php echo $f[8] ?>
		</div>
		<div class="realti_row"></div>
		<?php } ?>
		<?php if($f[11]) { ?>
		<div class="ic_afisha">
			<span>Возраст:</span> <?php echo $f[11] ?>
		</div>
		<div class="realti_row"></div>
		<?php } ?>
		<?php if($f[13]) { ?>
		<div class="ic_afisha">
			<span>Страна:</span> <?php echo $f[13] ?>
		</div>
		<div class="realti_row"></div>
		<?php } ?>
		<?php if($f[14]) { ?>
		<div class="ic_afisha">
			<span>Режисер:</span> <?php echo $f[14] ?>
		</div>
		<div class="realti_row"></div>
		<?php } ?>
		<?php if($f[10]) { ?>
		<div class="ic_afisha">
			<span>Расписание:</span> <?php echo $f[10] ?>
		</div>	
		<div class="realti_row"></div>
		<?php } ?>
		<?php if($f[72]) { ?>
		<div class="ic_afisha">
			<span>В ролях:</span> <?php echo $f[72] ?>
		</div>
		<div class="realti_row"></div>		
		<?php } ?>		
		<div class="ic_afisha">
			<div class="desc">
				<?php echo $this->item->fulltext?>
			</div>
		</div>
	</div>
	<?php if($f[9]) { ?>
	<div class="realti_row"></div>
	<div class="realti_row"></div>	
	<div class="treiler">
		<div class="col3">
		<h4><i class="fa fa-video-camera"></i> Трейлер</h4>
		</div>
		<iframe width="100%" height="350" src="https://www.youtube.com/embed/<?php echo $f[9] ?>" frameborder="0" allowfullscreen></iframe>
	</div>
	<?php } ?>
	<div class="realti_row"></div>
	<div class="realti_row"></div>	
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
	<?php echo RSFormProHelper::displayForm('12'); // ФОРМА РЕДАКТИРОВАНИЯ СОБЫТИЯ ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>

<a href="#x" class="overlay" id="delete"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('13'); // ФОРМА УДАЛЕНИЯ СОБЫТИЯ ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>
<?php } ?>
