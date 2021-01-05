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
<?php $dir = opendir(''.JPATH_BASE.'/images/resume/'.$item_id.'');
	$count_photo = 0;
	while($file = readdir($dir)){
	if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/resume/'.$item_id.'' . $file)){
		continue;
	}
	$count_photo++;
} ?>

<div class="vakansii resume <?php if($this->item->featured) { ?>cool<?php }?>" >
    <div class="kat_item_head">
        <h3>
            <a href="<?php echo $link?>#link_work" title="<?php echo $this->item->title ?>">
                <?php echo $this->item->title ?>
            </a>
        </h3></div>
<?php if($count_photo > 0) { ?>
	<div class="mod_news_img">
		<a href="<?php echo $link?>#link_work" title="<?php echo $this->item->title ?>"><span class="podlozhka"></span></a>
		<?php echo JHtml::_('content.prepare', '{gallery preview-width=145 preview-height=185}resume/'.$item_id.'{/gallery}'); ?>
	</div>
<?php } else { ?>
	<div class="old_mod_news_img">
		<?php if($img == '/images/resume/' or $img == '/images/resume/'.$item_id.'') { ?>
			<a href="<?php echo $link?>#link_work" title="<?php echo $this->item->title ?>"><img class="lazy" src="/images/no_image.jpg" alt="<?php echo $this->item->title ?>" /></a>
		<?php } else { ?>
			<a href="<?php echo $link?>#link_work" title="<?php echo $this->item->title ?>"><img class="lazy" src="<?php echo $img ?>" alt="<?php echo $this->item->title ?>" /></a>
		<?php } ?>
	</div>
<?php } ?>
<div class="kat_item_info">	

	<div class="vak_item_info">
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
	</div
	><div class="ic_cat">
		<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catid)); ?>" title="<?php echo $this->item->category_title ?>">
		<?php echo $this->item->category_title ?>
		</a>
	</div>
	<div class="fio">
		<?php echo $f[26]?>
	</div
	><div class="ic_vuz">
		Учебное заведение: <span><?php echo $f[29]?></span>
	</div><div class="ic_vak">
		Образование: <span><?php echo $f[28]?></span>
	</div><div class="ic_vak">
		Специальность: <span><?php echo $f[35]?></span>
	</div><div class="ic_vak">
		Дата рождения: <span><?php echo $f[25]?></span>
	</div><div class="ic_vak">
		Трудовой стаж: <span><?php echo $f[30]?></span>
	</div><div class="ic_vak">
		Семейное положение: <span><?php echo $f[31]?></span>
	</div><div class="ic_vak">
		Дети: <span><?php echo $f[32]?></span>
	</div>	
	</div
	><div class="vakansii_readmore">
		<a class="readmore" href="<?php echo $link?>">
			Подробнее
		</a>	
	</div
	><div class="zp price">
		желаемая з/п: <span><?php echo number_format($f[27],0,'',' ') ?></span>
		<?php echo $valuta1 ?>
	</div>
</div>
</div>
