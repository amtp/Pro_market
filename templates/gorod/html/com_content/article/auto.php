<?php
defined('_JEXEC') or die;
$item_id = $this->item->id;

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
require_once JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/rsform.php';

foreach($this->item->jcfields as $field) { 
		$f[$field->id] = $field->value;
	}
$phone = $f[98];

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
	
	var geocode = ymaps.geocode('<?php echo $gorod ?>, <?php echo $f[83] ?>', {results: 1});
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
				balloonContentBody: "<a href='<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catid)); ?>' title='<?php echo $this->item->parent_title ?> <?php echo $this->item->category_title ?>'><?php echo $this->item->parent_title ?> <?php echo $this->item->category_title ?></a><div>г. <?php echo $gorod ?>, <?php echo $f[83] ?></div><div>Телефон: <b><i class='fa fa-mobile'></i> <?php echo $f[98] ?></b></div>", 
				balloonContentFooter: "<div><?php echo $f[99] ?></div>", 
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
				<a href="#edit"><i class="fa fa-pencil-square-o"></i> Редактировать</a>
			</div>
			<div class="delete_button">
				<a href="#delete"><i class="fa fa-trash-o"></i> Удалить</a>
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
<div class="firma-page<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Article">


	<h1 itemprop="headline">
		<?php echo $this->escape($this->item->title); ?>
			<?php if($f[100] == 'Да') { ?>
				<sup class="new_auto">новый</sup>
			<?php } ?>		
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
			<span><?php echo $f[99]?></span>
		</div>		
	</div
	><div class="realty_col3 right">
		<div class="price">
			<span><?php echo number_format($f[96],0,'',' ') ?></span> <?php echo $valuta1 ?>
		</div>
	</div>
	<div class="realty_img_col">
<?php $dir = opendir(''.JPATH_BASE.'/images/avto/'.$item_id.'');
	$count_photo = 0;
	while($file = readdir($dir)){
	if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/avto/'.$item_id.'' . $file)){
		continue;
	}
	$count_photo++;
} ?>
		<div class="realty_img">
			<?php if($f[101] == 'Да') { ?>
				<div class="hot_auto"><a href="#"><i class="fa fa-flash"></i> срочно</a></div>
			<?php } ?>
			<?php if($count_photo > 0) { ?>
				<?php echo JHtml::_('content.prepare', '{gallery preview-width=600 preview-height=350}avto/'.$item_id.'{/gallery}'); ?>
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
			<i class="fa fa-clock-o"></i>
			<label>Год выпуска:</label> 
			<span><?php echo $f[84] ?></span> г
		</div>			
		
		<div class="realti_row">
			<i class="fa fa-globe"></i>
			<label>Пробег:</label> 
			<span><?php echo number_format($f[85],0,'',' ') ?></span> км
		</div>
		
		<div class="realti_row">
			<i class="fa fa-hourglass-o"></i>
			<label>Объем двигателя:</label> 
			<span><?php echo $f[97] ?></span> л
		</div>			
		
		<div class="realti_row">
			<i class="fa fa-wrench"></i>
			<label>Мощность двигателя:</label> 
			<span><?php echo $f[91] ?></span> л/с
		</div>	

		<div class="realti_row">
			<i class="fa fa-automobile"></i>
			<label>Тип кузова:</label> 
			<span><?php echo $f[87] ?></span>
		</div>		
		
		<div class="realti_row">
			<i class="fa fa-flask"></i>
			<label>Тип двигателя:</label> 
			<span><?php echo $f[90] ?></span>
		</div>
		
		<div class="realti_row">
			<i class="fa fa-gears"></i>
			<label>Коробка передач:</label> 
			<span><?php echo $f[92] ?></span>
		</div>
		
		<div class="realti_row">
			<i class="fa fa-cog"></i>
			<label>Привод:</label> 
			<span><?php echo $f[93] ?></span>
		</div>			
		
		<div class="realti_row">
			<i class="fa fa-paint-brush"></i>
			<label>Цвет:</label> 
			<span><?php echo $f[89] ?></span>
		</div>
		
		<div class="realti_row">
			<i class="fa fa-circle-o-notch"></i>
			<label>Руль:</label> 
			<span><?php echo $f[94] ?></span>
		</div>
		
		<div class="realti_row">
			<i class="fa fa-language"></i>
			<label>Кол-во дверей:</label> 
			<span><?php echo $f[88] ?></span>
		</div>			

		<div class="realti_row">
			<i class="fa fa-check-square-o"></i>
			<label>Состояние:</label> 
			<span <?php if($f[86] == 'Битый') { ?>style="color:#f00000"<?php } ?>><?php echo $f[86] ?></span>
		</div>
		
		<div class="realti_row">
			<i class="fa fa-users"></i>
			<label>Владельцев по ПТС:</label> 
			<span><?php echo $f[95] ?></span>
		</div>
		
	</div>
	
		<div class="auto_big_icon">
			<div class="realti_row_big">
				<small>год выпуска</small>
				<span><?php echo $f[84]?> г</span>
			</div
			><div class="realti_row_big">
				<small>пробег</small>
				<span><?php echo number_format($f[85],0,'',' ') ?> км</span>			
			</div
			><div class="realti_row_big">
				<small>объем</small>
				<span><?php echo $f[97]?> л</span>
			</div
			><div class="realti_row_big">
				<small>мощность</small>
				<span><?php echo $f[91]?> л/с</span>			
			</div
			><div class="realti_row_big">
				<small>двигатель</small>	
				<span><?php echo $f[90]?></span>
			</div
			><div class="realti_row_big">
				<small>привод</small>
				<span><?php echo $f[93]?></span>			
			</div
			><div class="realti_row_big">
				<small>коробка</small>
				<span><?php echo $f[92] ?></span>
			</div
			><div class="realti_row_big">
				<small>состояние</small>
				<span <?php if($f[86] == 'Битый') { ?>style="color:#f00000"<?php } ?>><?php echo $f[86]?></span>
			</div>
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
				<span><?php echo number_format($f[96],0,'',' ') ?></span> <i class="fa fa-rub"></i> 
			</div>
		<div class="realti_row"></div>
			<div class="realti_phone">
				<i class="fa fa-mobile"></i>
				<span class="hide-tail<?php echo $this->item->id ?>"><?php echo $phone ?></span>
				<small>
					<i class="fa fa-eye"></i> <a href="#" class="click-tel<?php echo $this->item->id ?>"> показать телефон</a>
				</small>
			</div>	
			<div class="realti_user">
				<span><?php echo $f[99]?></span>
			</div>
		<div class="realti_row"></div>
		<div class="realti_row"></div>
			<div class="realti_row_big">
				<small>год выпуска</small>
				<span><?php echo $f[84]?> г</span>
			</div
			><div class="realti_row_big">
				<small>пробег</small>
				<span><?php echo number_format($f[85],0,'',' ') ?> км</span>			
			</div>
		<div class="realti_row"></div>
		<div class="realti_row"></div>
			<div class="realti_row_big">
				<small>объем</small>
				<span><?php echo $f[97]?> л</span>
			</div
			><div class="realti_row_big">
				<small>состояние</small>
				<span <?php if($f[86] == 'Битый') { ?>style="color:#f00000"<?php } ?>><?php echo $f[86]?></span>
			</div>
		<div class="realti_row"></div>
		</div>		
	</div>
</div>

<?php if($user->id == $this->item->created_by) { ?>
<a href="#x" class="overlay" id="edit"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('28'); // ФОРМА РЕДАКТИРОВАНИЯ АВТО ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>

<a href="#x" class="overlay" id="delete"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('29'); // ФОРМА УДАЛЕНИЯ АВТО ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>

<a href="#x" class="overlay" id="pay-vip"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('39'); // ПОМЕСТИТЬ АВТО В VIP ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>

<a href="#x" class="overlay" id="pay-color"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('40'); // ФОРМА ВЫДЕЛЕНИЯ АВТО ЦВЕТОМ ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>

<a href="#x" class="overlay" id="pay-top"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('41'); // ФОРМА ПОДНЯТИЯ АВТО ВВЕРХ ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>

<a href="#x" class="overlay" id="pay-home"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('42'); // ФОРМА ДОБАВЛЕНИЯ АВТО НА ГЛАВНУЮ ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>
<?php } ?>