<?php
defined('_JEXEC') or die;
$item_id = $this->item->id;
require_once JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/rsform.php';

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
$images  = json_decode($this->item->images);
$user    = JFactory::getUser();

$app = JFactory::getApplication();
$template = $app->getTemplate(true);
$gorod = $template->params->get('gorod', '');
$maps = $template->params->get('maps', '');
$center_map = $template->params->get('center_map', '');
$api_key = $template->params->get('api_key', '');
$ya_knopki = $template->params->get('ya_knopki', '');
$valuta1 = $template->params->get('valuta', '');
$money_no = $template->params->get('money_no', '');
$domen = JUri::base();

foreach($this->item->jcfields as $field) { 
		$f[$field->id] = $field->value;
	}
$phone = $f[66];

	$date_now =  strtotime(date("d.m.Y G:i:s"));
    $date = $f[104]; //выделение цветом
    $d = new DateTime($date);
    $d->modify('+'.$f[103].' day');
    $data_color_end = strtotime($d->format("d.m.Y G:i:s"));//выделение цветом
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
		zoom: 15, 
		 controls: ['zoomControl']
	});
	
	var geocode = ymaps.geocode('<?php echo $gorod ?>, <?php echo $f[41] ?>', {results: 1});
	geocode.then(
		function (res) {
			// Выбираем первый результат геокодирования.
			var firstGeoObject = res.geoObjects.get(0);
			coords = firstGeoObject.geometry.getCoordinates();
			if (screen.width <= '480') {
				myMap.setCenter([coords[0], coords[1]+0.000]);
			} else {
				myMap.setCenter([coords[0], coords[1]+0.008]);
			}
			//myMap.setCenter([coords[0], coords[1]+0.008]);
			myMap.behaviors.disable('scrollZoom');	

			myPlacemark = new ymaps.Placemark(coords, { 
				// Чтобы балун и хинт открывались на метке, необходимо задать ей определенные свойства. 
				balloonContentHeader: '<?php echo $this->item->title ?>', 
				balloonContentBody: "<a href='<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catid)); ?>' title='<?php echo $this->item->parent_title ?> <?php echo $this->item->category_title ?>'><?php echo $this->item->parent_title ?> <?php echo $this->item->category_title ?></a><div>г. <?php echo $gorod ?>, <?php echo $f[41] ?></div><div>Телефон: <b><i class='fa fa-mobile'></i> <?php echo $f[66] ?></b></div>", 
				balloonContentFooter: "<div><?php echo $f[65] ?></div>", 
				hintContent: "Нажмите, для того, что бы посмотреть подробности" 
			}); 
			myMap.geoObjects.add(myPlacemark); 
		},
		function (err) {
		}
	);
} 
    </script>
	<?php if($user->id == $this->item->created_by) { ?>
		<div class="panel_left">
			<div class="edit_button">
				<a href="#edit"><i class="fa fa-pencil-square-o"></i></a>
			</div>
			<div class="delete_button">
				<a href="#delete"><i class="fa fa-trash-o"></i> </a>
			</div>
		</div
		><div class="panel_right">
			
	<?php if($user->id == $this->item->created_by) { ?>
		<?php if($money_no == 1) { ?>	
	<div class="item_pay_block">	
		<div class="item_pay_btn">
			<span class="pay_btn">
				<span class="pay_btn_cell">
					<a href="#pay-vip"><i class="fa fa-star"></i></a>
				</span>
				<span class="pay_btn_txt">
					<span>VIP статус</span>
				</span>
			</span>
		</div>
		<div class="item_pay_btn">
			<?php if($data_color_end < $date_now) { ?>
				<span class="pay_btn">
					<span class="pay_btn_cell">
						<a href="#pay-color"><i class="fa fa-paint-brush"></i></a>
					</span>
					<span class="pay_btn_txt">
						Выделить цветом
					</span>					
				</span>
			<?php } else { ?>
				<span class="pay_btn">
					<span class="pay_btn_cell">
						<i class="fa fa-paint-brush"></i>
					</span>
					<span class="pay_btn_txt">
						до <?php echo $d->format("d.m.Y G:i") ?>
					</span>					
				</span>			
			<?php } ?>	
		</div>
		<div class="item_pay_btn">
			<span class="pay_btn">
				<span class="pay_btn_cell">
					<a href="#pay-top"><i class="fa fa-arrow-up"></i></a>
				</span>
				<span class="pay_btn_txt">
					Поднять наверх
				</span>						
			</span>		
		</div>
		<div class="item_pay_btn">
			<span class="pay_btn">
				<span class="pay_btn_cell">
					<a href="#pay-home"><i class="fa fa-home"></i></a>
				</span>	
				<span class="pay_btn_txt">
					Вывести на главную
				</span>						
			</span>			
		</div>
	</div>	
		<?php } ?>
	<?php } ?>

		</div>
	<?php } ?>	
<div class="firma-page realty-page<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Article">
<div class="necontent">
<meta itemprop="inLanguage" content="<?php echo ($this->item->language === '*') ? JFactory::getConfig()->get('language') : $this->item->language; ?>" />
	<h1 itemprop="headline">
		<?php echo $this->escape($this->item->title); ?>
	</h1>
	<div class="realty_col3">
		<div class="ic_cat">
			<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catid)); ?>" title="<?php echo $this->item->parent_title ?> <?php echo $this->item->category_title ?>">
				<?php echo $this->item->parent_title ?> <?php echo $this->item->category_title ?>
			</a>
		</div>	
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
	</div>
	</div
	><div class="realty_col3 right">
		<div class="ic_big_phone">
			<i class="fa fa-mobile"></i>
			<span class="hide-tail<?php echo $this->item->id ?>"><?php echo $phone ?></span>
			<small>
				<i class="fa fa-eye"></i> <a href="#" class="click-tel<?php echo $this->item->id ?>"> показать телефон</a>
			</small>
		</div>	
		<div class="realti_user">
			<span><?php echo $f[65]?></span>
		</div>		
	</div
	><div class="realty_col3 right">
		<div class="price">
			<span><?php echo number_format(intval($f[62]),0,'',' ') ?></span> <?php echo $valuta1 ?>
			<div class="torg"><?php echo $f[63]?></div>
		</div>
	</div>
	<div class="realty_img_col">
<?php $dir = opendir(''.JPATH_BASE.'/images/realty/'.$item_id.'');
	$count_photo = 0;
	while($file = readdir($dir)){
	if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/realty/'.$item_id.'' . $file)){
		continue;
	}
	$count_photo++;
} ?>
		<div class="realty_img">
			<?php if($count_photo > 0) { ?>
				<?php echo JHtml::_('content.prepare', '{gallery preview-width=600 preview-height=350}realty/'.$item_id.'{/gallery}'); ?>
			<?php } else { ?>
				<img class="lazy" src="<?php echo $domen ?><?php echo $images->image_intro ?>" />
			<?php } ?>
		</div>

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
	<?php echo JHtml::_('content.prepare', '{gallery preview-width=130 preview-height=95}gallery/'.$item_id.'{/gallery}'); ?>
<?php } ?>	

</div>

		<div class="realti_row"></div>
			<div class="realti_row_big">
				<span><?php echo $f[50]?> м<sup>2</sup></span>
				<small>общая</small>
			</div
			><div class="realti_row_big">
				<span><?php echo $f[51]?> м<sup>2</sup></span>
				<small>жилая</small>			
			</div
			><div class="realti_row_big">
				<span><?php echo $f[52]?> м<sup>2</sup></span>
				<small>кухня</small>			
			</div
			><div class="realti_row_big">
				<span><?php echo $f[55]?></span>
				<small>ремонт</small>			
			</div>	
		<div class="realti_row"></div>
		<div class="realti_row"></div>
			<div class="realti_row_big">
				<span><?php echo $f[48]?> этаж</span>
				<small>из <?php echo $f[49]?> в здании</small>			
			</div
			><div class="realti_row_big">
				<span><?php echo $f[42]?></span>
				<small>год постройки</small>			
			</div
			><div class="realti_row_big">
				<span><?php echo (int)(intval($f[62]) / intval($f[50]))?> <?php echo $valuta1 ?></span>
				<small>цена за м<sup>2</sup></small>			
			</div
			><div class="realti_row_big">
				<span><?php echo $f[53]?></span>
				<small>санузел</small>			
			</div>
		<div class="realti_row"></div>	
		<div class="realti_row"></div>
	
	</div
	><div class="realty_info_col">
		<?php if($ya_knopki == '1') { ?>
			<div class="social_button">
				<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
				<script src="//yastatic.net/share2/share.js"></script>
				<div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir,gplus" data-counter="" data-image="<?php echo $domen;?><?php echo $images->image_intro;?>" data-description="<?php echo $this->item->fulltext?>"></div>	
			</div>
		<?php } ?>	
		<div class="realti_row">
			<i class="fa fa-rouble"></i>
			<label>Цена за м<sup>2</sup>:</label> 
			<span><?php echo (int)(intval($f[62]) / intval($f[50]))?> <?php echo $valuta1 ?></span>
		</div>		
		<div class="realti_row">
			<i class="fa fa-sort-numeric-asc"></i>
			<label>Этаж:</label> 
			<span><?php echo $f[48]?> из <?php echo $f[49]?></span>
		</div>
		<div class="realti_row">
			<i class="fa fa-building-o"></i>
			<label>Тип дома:</label> 
			<span><?php echo $f[43]?></span>
		</div>
		<?php if($f[42]) { ?>
		<div class="realti_row">
			<i class="fa fa-calendar-o"></i>
			<label>Год постройки:</label> 
			<span><?php echo $f[42]?></span>
		</div>	
		<?php } ?>
		<?php if($f[50]) { ?>
		<div class="realti_row">
			<i class="fa fa-calculator"></i>
			<label>Общая площадь:</label> 
			<span><?php echo $f[50]?> м<sup>2</sup></span>
		</div>
		<?php } ?>
		<?php if($f[51]) { ?>
		<div class="realti_row">
			<i class="fa fa-check"></i>
			<label>Жилая площадь:</label> 
			<span><?php echo $f[51]?> м<sup>2</sup></span>
		</div>
		<?php } ?>
		<?php if($f[52]) { ?>
		<div class="realti_row">
			<i class="fa fa-check"></i>
			<label>Площадь кухни:</label> 
			<span><?php echo $f[52]?> м<sup>2</sup></span>
		</div>
		<?php } ?>
		<?php if($f[55]) { ?>
		<div class="realti_row">
			<i class="fa fa-wrench"></i>
			<label>Ремонт:</label> 
			<span><?php echo $f[55]?></span>
		</div>
		<?php } ?>
		<?php if($f[53]) { ?>
		<div class="realti_row">
			<i class="fa fa-s15"></i>
			<label>Санузел:</label> 
			<span><?php echo $f[53]?></span>
		</div>
		<?php } ?>
		<?php if($f[54]) { ?>
		<div class="realti_row">
			<i class="fa fa-eye"></i>
			<label>Балкон:</label> 
			<span><?php echo $f[54]?></span>
		</div>
		<?php } ?>
		<?php if($f[44]) { ?>
		<div class="realti_row">
			<i class="fa fa-paypal"></i>
			<label>Парковка:</label> 
			<span><?php echo $f[44]?></span>
		</div>
		<?php } ?>
		<?php if($f[45]) { ?>
		<div class="realti_row"></div>
		<div class="realti_row">
			<i class="fa fa-long-arrow-up"></i>
			<label>Лифт:</label> 
			<span><?php echo $f[45]?></span>
		</div>
		<?php } ?>
		<?php if($f[46]) { ?>
		<div class="realti_row">
			<i class="fa fa-trash-o"></i>
			<label>Мусоропровод:</label> 
			<span><?php echo $f[46]?></span>
		</div>
		<?php } ?>
		<?php if($f[47]) { ?>
		<div class="realti_row">
			<i class="fa fa-shield"></i>
			<label>Охрана:</label> 
			<span><?php echo $f[47]?></span>
		</div>
		<?php } ?>
		<?php if($f[56]) { ?>
		<div class="realti_row">
			<i class="fa fa-fax"></i>
			<label>Телефон:</label> 
			<span><?php echo $f[56]?></span>
		</div>
		<?php } ?>
		<?php if($f[57]) { ?>
		<div class="realti_row">
			<i class="fa fa-wifi"></i>
			<label>Интенет:</label> 
			<span><?php echo $f[57]?></span>
		</div>
		<?php } ?>
		<?php if($f[58]) { ?>
		<div class="realti_row">
			<i class="fa fa-archive"></i>
			<label>Мебель:</label> 
			<span><?php echo $f[58]?></span>
		</div>
		<?php } ?>
		<?php if($f[59]) { ?>
		<div class="realti_row">
			<i class="fa fa-building"></i>
			<label>Холодильник:</label> 
			<span><?php echo $f[59]?></span>
		</div>
		<?php } ?>
		<?php if($f[60]) { ?>
		<div class="realti_row">
			<i class="fa fa-object-group"></i>
			<label>Встроенная техника:</label> 
			<span><?php echo $f[60]?></span>
		</div>	
		<?php } ?>
		<?php if($f[61]) { ?>
		<div class="realti_row">
			<i class="fa fa-snowflake-o"></i>
			<label>Кондиционер:</label> 
			<span><?php echo $f[61]?></span>
		</div>
		<?php } ?>
	</div>
	
	
<div class="tabs">
    <input id="tab1" type="radio" name="tabs" checked>
    <label for="tab1" title="Описание"><i class="fa fa-files-o"></i> Описание</label>

    <input id="tab3" type="radio" name="tabs">
    <label for="tab3" title="Отзывы"><i class="fa fa-comments-o"></i> Вопросы
		(<?php
		$comments = JPATH_SITE . '/components/com_jcomments/jcomments.php';
		if (file_exists($comments)) {
		require_once($comments);
		$options = array();
		$options['object_id'] = $this->item->id;
		$options['object_group'] = 'com_content';
		$options['published'] = 1;
		$count = JCommentsModel::getCommentsCount($options);
		echo $count ? ''. $count . '' : '0';
		} ?>)	
	</label>

    <section id="content-tab1">
		<div class="realty_desc">
			<div class="module_top">
				<h3><span class="fa fa-files-o"></span> Купить <?php echo $this->item->title ?></h3>
			</div>
			<div>
				<?php echo $this->item->introtext ?>
			</div>
			<div class="desc">
				<?php echo $this->item->fulltext?>
			</div>		
		</div>
    </section>  

    <section id="content-tab3">
		<?php
			$comments = JPATH_ROOT . '/components/com_jcomments/jcomments.php';
			if (file_exists($comments)) {
			require_once($comments);
			echo JComments::showComments($this->item->id, 'com_content', $this->item->title);
			}
		?>
    </section> 	
</div>	
	
	<div id="YMapsID">
		<span class="loading">
			<i class="fa fa-spinner fa-spin"></i>
			<span>Загружаем карту</span>
		</span>
		<div class="map_info">
		<div class="realti_row"></div>
			<div class="realti_price">
				<span><?php echo $f[62]?></span> <?php echo $valuta1 ?></i> 
			</div>
			<div class="torg"><?php echo $f[63]?></div>				
		<div class="realti_row"></div>
			<div class="realti_phone">
				<i class="fa fa-mobile"></i>
				<span class="hide-tail<?php echo $this->item->id ?>"><?php echo $phone ?></span>
				<small>
					<i class="fa fa-eye"></i> <a href="#" class="click-tel<?php echo $this->item->id ?>"> показать телефон</a>
				</small>
				<div class="realty_user"><?php echo $f[64]?> <?php echo $f[65]?></div>
			</div>	
		<div class="realti_row"></div>
			<div class="realti_row_big">
				<span><?php echo $f[48]?> этаж</span>
				<small>из <?php echo $f[49]?> в здании</small>			
			</div
			><div class="realti_row_big">
				<span><?php echo $f[55]?></span>
				<small>ремонт</small>			
			</div>
		<div class="realti_row"></div>
			<div class="realti_row_big">
				<span><?php echo $f[53]?></span>
				<small>санузел</small>
			</div
			><div class="realti_row_big">
				<span><?php echo $f[50]?> м<sup>2</sup></span>
				<small>площадь</small>
			</div>
		<div class="realti_row"></div>
		</div>		
	</div>
</div>
</div>
<?php if($user->id == $this->item->created_by) { ?>
<a href="#x" class="overlay" id="edit"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('20'); // ФОРМА РЕДАКТИРОВАНИЯ НЕДВИЖИМОСТИ ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>

<a href="#x" class="overlay" id="delete"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('21'); // ФОРМА УДАЛЕНИЯ НЕДВИЖИМОСТИ ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>

<a href="#x" class="overlay" id="pay-vip"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('43'); // ПОМЕСТИТЬ НЕДВИЖИМОСТЬ В VIP ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>

<a href="#x" class="overlay" id="pay-color"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('44'); // ФОРМА ВЫДЕЛЕНИЯ НЕДВИЖИМОСТИ ЦВЕТОМ ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>

<a href="#x" class="overlay" id="pay-top"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('45'); // ФОРМА ПОДНЯТИЯ НЕДВИЖИМОСТИ ВВЕРХ ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>

<a href="#x" class="overlay" id="pay-home"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('46'); // ФОРМА ДОБАВЛЕНИЯ НЕДВИЖИМОСТИ НА ГЛАВНУЮ ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>
<?php } ?>