<?php
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
$images = json_decode($this->item->images);
$user = JFactory::getUser();
JHtml::_('behavior.caption');
$item_id = $this->item->id;
require_once JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/rsform.php';

$app = JFactory::getApplication();
$template = $app->getTemplate(true);
$gorod = $template->params->get('gorod', '');
$valuta1 = $template->params->get('valuta', '');

foreach($this->item->jcfields as $field) { 
		$f[$field->id] = $field->value;
	}
$phone = $f[33];
?>
<script type="text/javascript">
jQuery.fn.textToggle = function(d, b, e) {
    return this.each(function(f, a) {
        a = jQuery(a);
        var c = jQuery(d).eq(f),
            g = [b, c.text()],
            h = [a.text(), e];
        c.text(b).show();
        jQuery(a).click(function(b) {
            b.preventDefault();
            c.text(g.reverse()[0]);
            a.text(h.reverse()[0])
        })
    })
};
jQuery(function(){
jQuery('.click-tel<?php echo $this->item->id ?>').textToggle(".hide-tail<?php echo $this->item->id ?>","<?php echo $phone[0] ?><?php echo $phone[1] ?><?php echo $phone[2] ?><?php echo $phone[3] ?><?php echo $phone[4] ?><?php echo $phone[5] ?><?php echo $phone[6] ?><?php echo $phone[7] ?><?php echo $phone[8] ?><?php echo $phone[9] ?><?php echo $phone[10] ?><?php echo $phone[11] ?><?php echo $phone[12] ?><?php echo $phone[13] ?><?php echo $phone[14] ?>-XX","скрыть телефон")
});
</script>
<a id="link_work"></a>
<div class="resume_item <?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Article">
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
		<div class="zp_resume">
			желаемая заработная плата: <span><?php echo number_format($f[27],0,'',' ') ?></span>
			<?php echo $valuta1 ?>
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
			Резюме #<?php echo $this->item->id ?>
		</div>
		<div class="ic">
			<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catid)); ?>" title="<?php echo $this->item->category_title ?>">
			<?php echo $this->item->category_title ?>
			</a>
		</div>	
	</div>
	<div class="resume_logo_block">
<?php $dir = opendir(''.JPATH_BASE.'/images/resume/'.$item_id.'');
	$count_photo = 0;
	while($file = readdir($dir)){
	if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/resume/'.$item_id.'' . $file)){
		continue;
	}
	$count_photo++;
} ?>		
	<div class="news_logo padding">
<?php if($count_photo > 0) { ?>
	<div class="mod_news_img ">
		<?php echo JHtml::_('content.prepare', '{gallery preview-width=250 preview-height=250}resume/'.$item_id.'{/gallery}'); ?>
	</div>
<?php } else { ?>		
		<?php if($images->image_intro == '/images/resume/' or $images->image_intro == '/images/resume/'.$item_id.'/') { ?>
			<img src="/images/no_image.jpg" alt="<?php echo $this->item->title ?>"/>
		<?php } else { ?>
			<img src="<?php echo $images->image_intro ?>" alt="<?php echo $this->item->title ?>"/>
		<?php } ?>
<?php } ?>
	</div>		
	</div
	><div class="vakansiya_info">
		<div class="fio">
			<?php echo $f[26]?>
		</div>

		<div class="ic_vuz">
			Учебное заведение: <span><?php echo $f[29]?></span>
		</div><div class="ic_resume">
			Образование: <span><?php echo $f[28]?></span>
		</div><div class="ic_resume">
			Специальность: <span><?php echo $f[35]?></span>
		</div><div class="ic_resume">
			Дата рождения: <span><?php echo $f[25]?> г.</span>
		</div><div class="ic_resume">
			Трудовой стаж: <span><?php echo $f[30]?></span>
		</div><div class="ic_resume">
			Семейное положение: <span><?php echo $f[31]?></span>
		</div><div class="ic_resume">
			Дети: <span><?php echo $f[32]?></span>
		</div>	
		<div class="vak_phone">
			<i class="fa fa-mobile"></i>
			<span class="hide-tail<?php echo $this->item->id ?>"><?php echo $phone ?></span>
			<small>
				<i class="fa fa-eye"></i> <a href="#" class="click-tel<?php echo $this->item->id ?>"> показать телефон</a>
			</small>
		</div>
		<div class="vak_mail">
			<i class="fa fa-envelope-o"></i> <span><?php echo $f[34] ?></span>
		</div>
	</div>
<div class="col3">
	<h4><i class="fa fa-wrench"></i> Последнее место работы</h4>
</div>	
	<div class="opit_firma">
		<span><?php echo $f[40]?></span>
	</div>
	<div class="opit_date">
		с <?php echo $f[36]?> - <?php echo $f[37]?>
	</div
	><div class="opit_info">
		<div class="opit_dolzhnost">
			Должность: <span><?php echo $f[38]?></span>
		</div>		
		<div class="opit_obyazannosti">
			Должностные обязанности: <span><?php echo $f[39]?></span>
		</div>		
	</div>
	<div class="realti_row"></div>
	<div class="col3">
		<h4><i class="fa fa-gear"></i> Профессиональные навыки</h4>
		<?php echo $this->item->introtext?>
	</div>
	<div class="realti_row"></div>
	<div class="col3">
		<h4><i class="fa fa-check-square-o"></i> Дополнительная информация</h4>
		<?php echo $this->item->fulltext?>
	</div>	
	<div class="realti_row"></div>

<div class="col3">
<h4><i class="fa fa-comments"></i> Написать кандидату</h3>
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
	<?php echo RSFormProHelper::displayForm('18'); // ФОРМА РЕДАКТИРОВАНИЯ резюме ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>

<a href="#x" class="overlay" id="delete"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('19'); // ФОРМА УДАЛЕНИЯ вакансии ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>
<?php } ?>

