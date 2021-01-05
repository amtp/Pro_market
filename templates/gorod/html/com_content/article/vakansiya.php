<?php
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
$images = json_decode($this->item->images);
$user = JFactory::getUser();
JHtml::_('behavior.caption');
require_once JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/rsform.php';

$item_id = $this->item->id;
$app = JFactory::getApplication();
$template = $app->getTemplate(true);
$gorod = $template->params->get('gorod', '');
$maps = $template->params->get('maps', '');
$center_map = $template->params->get('center_map', '');
$api_key = $template->params->get('api_key', '');
$ya_knopki = $template->params->get('ya_knopki', '');
$valuta1 = $template->params->get('valuta', '');
$domen = JUri::base();

foreach($this->item->jcfields as $field) { 
		$f[$field->id] = $field->value;
	}
$phone = $f[18];	
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
<script src="https://api-maps.yandex.ru/2.1/?apikey=85ad9d82-083c-4878-a858-401ac7bf15d1&lang=ru_RU" type="text/javascript"></script>
<script type="text/javascript">
ymaps.ready(init); 
function init () { 
    var myMap = new ymaps.Map("YMapsID", { 
		center: [<?php echo $center_map ?>], 
		zoom: 16, 
		 controls: ['zoomControl']
	});
	
	var geocode = ymaps.geocode('г. <?php echo $gorod ?>, <?php echo $f[17] ?>', {results: 1});
	geocode.then(
		function (res) {
			// Выбираем первый результат геокодирования.
			var firstGeoObject = res.geoObjects.get(0);
			coords = firstGeoObject.geometry.getCoordinates();
			myMap.setCenter([coords[0], coords[1]+0]);
			myMap.behaviors.disable('scrollZoom');	

			
			myPlacemark = new ymaps.Placemark(coords, {
				balloonContentHeader: '<?php echo $this->item->title ?> от <?php echo $f[16] ?> руб.', 
				balloonContentBody: "<div>г. <?php echo $gorod ?>, <?php echo $f[17] ?></div><div>Телефон: <b><i class='fa fa-mobile'></i> <?php echo $f[18] ?></b></div>", 
				balloonContentFooter: "<div>График работы: <?php echo $f[22] ?></div>", 
				hintContent: "Нажмите, для того, что бы посмотреть подробности" 
			}); 

			myMap.geoObjects.add(myPlacemark); 
		},
		function (err) {
		}
	);
} 
</script>
<a id="link_work"></a>
<div class="vakansii <?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Article">
	<?php if($user->id == $this->item->created_by) { ?>
		<div class="panel_left">
			<div class="edit_button">
				<a href="#edit-firma"><i class="fa fa-pencil-square-o"></i> Редактировать</a>
			</div>
			<div class="delete_button">
				<a href="#delete-firma"><i class="fa fa-trash-o"></i> Удалить</a>
			</div>
		</div
		>
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
		<div class="ic_cat">
			<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catid)); ?>" title="<?php echo $this->item->category_title ?>">
			<?php echo $this->item->category_title ?>
			</a>
		</div>	
	</div>
<div class="vakansiya_logo_block">
<div class="padding">
<?php $dir = opendir(''.JPATH_BASE.'/images/vakansii/'.$item_id.'');
	$count_photo = 0;
	while($file = readdir($dir)){
	if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/vakansii/'.$item_id.'' . $file)){
		continue;
	}
	$count_photo++;
} ?>	

<?php if($count_photo > 0) { ?>
	<?php echo JHtml::_('content.prepare', '{gallery preview-width=200 preview-height=200}vakansii/'.$item_id.'{/gallery}'); ?>
<?php } else { ?>		
		<?php if($images->image_intro == '/images/vakansii/' or $images->image_intro == '/images/vakansii/'.$item_id.'') { ?>
			<img src="/images/no_image.jpg" alt="<?php echo $this->item->title ?>"/>
		<?php } else { ?>
			<img src="<?php echo $images->image_intro ?>" alt="<?php echo $this->item->title ?>"/>
		<?php } ?>
<?php } ?>
</div>
</div
><div class="vakansiya_info">
		<?php if($ya_knopki == '1') { ?>
			<div class="social_button">
				<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
				<script src="//yastatic.net/share2/share.js"></script>
				<div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir,gplus" data-counter="" data-image="<?php echo $domen;?><?php echo $images->image_intro;?>" data-description="<?php echo $this->item->fulltext?>"></div>	
			</div>
		<?php } ?>	
		<div class="price zp">
			от: <?php echo number_format($f[16],0,'',' ') ?> <?php echo $valuta1 ?>
		</div>		
		<div class="vak_ic">
			<?php echo $f[15] ?>
		</div>
		<div class="vak_ic">
			<span><?php echo $f[24] ?></span>
		</div>		
		<div class="vak_ic">
			Образование: <span><?php echo $f[20] ?></span>
		</div>
		<div class="vak_ic">
			Опыт работы: <span><?php echo $f[21] ?></span>
		</div>
		<div class="vak_ic">
			График работы: <span><?php echo $f[22] ?></span>
		</div>
		<div class="vak_ic">
			Адрес: <span><?php echo $f[17] ?></span>
		</div>
	</div>
	<div class="ic_big_phone">
		<i class="fa fa-mobile"></i>
		<span class="hide-tail<?php echo $this->item->id ?>"><?php echo $phone ?></span>
		<small>
			<i class="fa fa-eye"></i> <a href="#" class="click-tel<?php echo $this->item->id ?>"> показать телефон</a>
		</small>
	</div>
	<div class="vak_mail">
		<i class="fa fa-envelope-o"></i> <span><?php echo $f[19] ?></span>
	</div>	
<div class="realti_row"></div>	
	<div class="col3">
		<h4><i class="fa fa-gear"></i> Должностные обязанности</h4>
		<?php echo $this->item->introtext?>
	</div>
<div class="realti_row"></div>
	<div class="col3">
		<h4><i class="fa fa-check-square-o"></i> Условия</h4>
		<?php echo $this->item->fulltext?>
	</div>
<div class="realti_row"></div>	
	<div class="col3">
		<h4><i class="fa fa-user"></i> Требования к кандидату</h4>
		<?php echo $f[23] ?>
	</div>	
	
	
<div id="YMapsID">
</div>
<div class="col3">
<h4><i class="fa fa-comments"></i> Задать вопрос</h4>
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
<a href="#x" class="overlay" id="edit-firma"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('16'); // ФОРМА РЕДАКТИРОВАНИЯ вакансии ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>

<a href="#x" class="overlay" id="delete-firma"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('17'); // ФОРМА УДАЛЕНИЯ вакансии ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>
<?php } ?>
