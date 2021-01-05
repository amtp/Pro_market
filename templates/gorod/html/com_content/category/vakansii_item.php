<?php
defined('_JEXEC') or die;
$params = $this->item->params;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
$img = json_decode($this->item->images)->image_intro;
$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
foreach($this->item->jcfields as $v) { 
		$f[$v->id] = $v->value;
	}
$app = JFactory::getApplication();
$templ = $app->getTemplate(true);	
$valuta1 = $templ->params->get('valuta', '');

$item_id = $this->item->id;
?>
<?php $dir = opendir(''.JPATH_BASE.'/images/vakansii/'.$item_id.'');
	$count_photo = 0;
	while($file = readdir($dir)){
	if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/vakansii/'.$item_id.'' . $file)){
		continue;
	}
	$count_photo++;
} ?>
<div class="vakansii <?php if($this->item->featured) { ?>cool<?php }?>" >
    <div class="kat_item_head">
        <h3>
            <a href="<?php echo $link?>#link_work" title="<?php echo $this->item->title ?>">
                <?php echo $this->item->title ?>
            </a>
        </h3>
    </div>
<?php if($count_photo > 0) { ?>
	<div class="mod_news_img">
		<a href="<?php echo $link?>#link_work" title="<?php echo $this->item->title ?>"><span class="podlozhka"></span></a>
		<?php echo JHtml::_('content.prepare', '{gallery preview-width=145 preview-height=145}vakansii/'.$item_id.'{/gallery}'); ?>
	</div>
<?php } else { ?>
	<div class="old_mod_news_img">
		<?php if($img == '/images/vakansii/' or $img == '/images/vakansii/'.$item_id.'') { ?>
			<a href="<?php echo $link?>#link_work" title="<?php echo $this->item->title ?>"><img class="lazy" src="/images/no_image.jpg" alt="<?php echo $this->item->title ?>" /></a>
		<?php } else { ?>
			<a href="<?php echo $link?>#link_work" title="<?php echo $this->item->title ?>"><img class="lazy" src="<?php echo $img ?>" alt="<?php echo $this->item->title ?>" /></a>
		<?php } ?>
	</div>
<?php } ?>
<div class="kat_item_info">	

	<div class="vak_item_info">
	<div class="ic_cat">
		<span><?php echo $f[15]?></span>
		<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catid)); ?>" title="<?php echo $this->item->category_title ?>">
		<?php echo $this->item->category_title ?>
		</a>
	</div>
	<div class="mini_icons">
		<div class="ic">
			<i class="fa fa-calendar-check-o"></i>
			<?php echo JHTML::_('date', $this->item->created , JText::_('DATE_FORMAT_LC3')); ?>
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
		<div class="ic">
			#<?php echo $this->item->id ?>
		</div>		
	</div>
	<div class="ic_vak">
		Образование: <span><?php echo $f[20]?></span>
	</div><div class="ic_vak">
		Опыт: <span><?php echo $f[21]?></span>
	</div><div class="ic_vak">
		График: <span><?php echo $f[22]?></span>
	</div><div class="ic_vak">
		Адрес: <span><?php echo $f[17]?></span>
	</div>
	<div class="vakansii_readmore">
		<a class="readmore" href="<?php echo $link?>">
			Подробнее
		</a>
	</div
	><div class="zp price">
		от: <span><?php echo number_format($f[16],0,'',' ') ?></span>
		<?php echo $valuta1 ?>
	</div>
</div>
</div>
</div>