<?php
defined('_JEXEC') or die;
$item_id = $this->item->id;
require_once JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/rsform.php';

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
$images  = json_decode($this->item->images);
$user    = JFactory::getUser();

$document = JFactory::getDocument();
$renderer = $document->loadRenderer('modules');
$options = array('style' => 'top');

$app = JFactory::getApplication();
$template = $app->getTemplate(true);
$gorod = $this->item->cityname;
$maps = $template->params->get('maps', '');
$center_map = $template->params->get('center_map', '');
$api_key = $template->params->get('api_key', '');
$ya_knopki = $template->params->get('ya_knopki', '');
$rating_user = $template->params->get('rating_user', '');
$money_no = $template->params->get('money_no', '');
$valuta1 = $template->params->get('valuta', '');
$domen = JUri::base();
$urip = JFactory::getURI();
$thisurl = $urip->toString();
foreach($this->item->jcfields as $field) { 
		$f[$field->id] = $field->value;
	}
$phone= $f[78];	

	$date_now = date("d.m.Y G:i:s");
    $date = $f[104]; //выделение цветом
    $d = new DateTime($date);
    $d->modify('+'.$f[103].' day');
    $data_color_end = $d->format("d.m.Y G:i:s");//выделение цветом

?>
	<?php if($user->id == $this->item->created_by) { ?>
		<div class="panel_left">
			<div class="edit_button">
				<a href="#edit"><i class="fa fa-pencil-square-o"></i> </a>
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
<script src="https://api-maps.yandex.ru/2.1/?apikey=85ad9d82-083c-4878-a858-401ac7bf15d1&lang=ru_RU" type="text/javascript"></script>
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
<?php if($f[80]) { ?>
<script type="text/javascript">
ymaps.ready(init); 
function init () { 
    var myMap = new ymaps.Map("YMapsID", { 
		center: [<?php echo $center_map ?>], 
		zoom: 15, 
		 controls: ['zoomControl']
	});
	
	var geocode = ymaps.geocode('г. <?php echo $gorod ?>, <?php echo $f[80] ?>', {results: 1});
	geocode.then(
		function (res) {
			// Выбираем первый результат геокодирования.
			var firstGeoObject = res.geoObjects.get(0);
			coords = firstGeoObject.geometry.getCoordinates();
			if (screen.width <= '480') {
				myMap.setCenter([coords[0], coords[1]+0.000]);
			} else {
				myMap.setCenter([coords[0], coords[1]+0.000]);
			}
			//myMap.setCenter([coords[0], coords[1]+0.008]);
			myMap.behaviors.disable('scrollZoom');	

			
			myPlacemark = new ymaps.Placemark(coords, { 
				// Чтобы балун и хинт открывались на метке, необходимо задать ей определенные свойства. 
				balloonContentHeader: '<?php echo $this->item->title ?>', 
				balloonContentBody: "<div>г. <?php echo $gorod ?>, <?php echo $f[80] ?></div><div>Телефон: <b><i class='fa fa-mobile'></i> <?php echo $f[78] ?></b></div>", 
				balloonContentFooter: "<div><i class='fa fa-user'></i> <?php echo $this->item->author ?></div>", 
				hintContent: "Нажмите, для того, что бы посмотреть подробности" 
			}); 

			myMap.geoObjects.add(myPlacemark); 
		},
		function (err) {
		}
	);
} 
</script>
<?php } ?>
<div class="doska-page<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Organization">
<div class="necontent">
    <?php if($this->item->featured)	{ ?>
	<div class="featured">
		<span class="fa-stack fa-lg">
		<i class="fa fa-thumbs-o-up fa-stack-1x"></i>
		<i class="fa fa-circle-o-notch fa-spin fa-stack-2x"></i>
		</span>
		<span>Мы рекомендуем</span>
	</div>
<?php } ?>
	<h1 itemprop="name">
		<?php echo $this->escape($this->item->title); ?>
	</h1>

	<div class="doska_img">
		<?php $dir = opendir(''.JPATH_BASE.'/images/doska/'.$item_id.'');
			$count_photo = 0;
			while($file = readdir($dir)){
			if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/doska/'.$item_id.'' . $file)){
				continue;
			}
			$count_photo++;
		} ?>
			
		<?php if($count_photo > 0) { ?>
				<?php echo JHtml::_('content.prepare', '{gallery}doska/'.$item_id.'{/gallery}'); ?>
			<?php } else { ?>
				<img itemprop="logo" class="lazy" src="<?php echo $domen?><?php echo $images->image_intro ?>">
		<?php } ?>			
	</div
	><div class="doska_info">
		<?php if($ya_knopki == '1') { ?>
			<div class="ic social_button">
				<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
				<script src="//yastatic.net/share2/share.js"></script>
				<div class="ya-share2" data-services="whatsapp,vkontakte,facebook,odnoklassniki,moimir,gplus" data-description="<?php if($this->item->id) { ?><?php echo $this->item->fulltext?><?php } ?>" data-counter="" data-image="<?php echo $domen;?><?php echo $images->image_intro;?>"></div>
                <div class="js-share copy fa fa-link"   onclick="  copyTextToClipboard('<?php echo $thisurl ?>');" title="Скопировать">
                </div>
            </div>

		<?php } ?>		
		<div class="ic_big_phone">
			<i class="fa fa-mobile"></i>
			<span itemprop="telephone" class="hide-tail<?php echo $this->item->id ?>"><?php echo $phone ?></span>
				<small>
					<i class="fa fa-eye"></i> <a href="#" class="click-tel<?php echo $this->item->id ?>"> показать телефон</a>
				</small>
		</div>	
		<div class="ic_cat">
			<span>Раздел: </span>
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
	</div>	
		<div class="price">
			<small>Цена: </small>
			<span><?php echo number_format($f[79],0,'',' ') ?></span> <?php echo $valuta1 ?>
			<?php if($f[82] == 'Да'){?>
				<sup>возможен торг</sup>
			<?php } ?>
		</div>
		<?php if($f[81]) {?>
		<!--noindex-->
		<div class="ic_big">
			<i class="fa fa-envelope-o"></i>
			<span><?php echo $f[81] ?></span>
		</div>
		<!--/noindex-->	
		<?php } ?>
		<div class="ic_big">
			<i class="fa fa-user"></i>
			<span><?php echo $this->item->author ?></span>
		</div>
		
		<?php if($f[80]) {?>
		<div class="ic_big">
			<i class="fa fa-map-marker"></i>
			<?php echo "г. ".$gorod." ".$f[80] ?>
		</div>	
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
	<?php echo JHtml::_('content.prepare', '{gallery preview-width=210 preview-height=150}gallery/'.$item_id.'{/gallery}'); ?>
<?php } ?>
</div>

<?php $position = 'recomend'; 
	echo $renderer->render($position, $options, null);
?>	

<div class="tabs">
    <input id="tab1" type="radio" name="tabs" checked>
    <label for="tab1" title="Описание"><i class="fa fa-files-o"></i> Описание</label>

    <input id="tab3" type="radio" name="tabs">
    <label for="tab3" title="Отзывы"><i class="fa fa-comments-o"></i> Вопросы продавцу
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
		<div class="desc">
			<?php echo $this->item->fulltext?>
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
<?php if($f[80]) { ?>
<div id="YMapsID">
	<span class="loading">
		<i class="fa fa-spinner fa-spin"></i>
		<span>Загружаем карту</span>
	</span>
</div>
<?php } ?>

</div>

<?php if($user->id == $this->item->created_by) { ?>

<a href="#x" class="overlay" id="edit"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('24'); // ФОРМА РЕДАКТИРОВАНИЯ ОБЪЯВЛЕНИЯ ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>

<a href="#x" class="overlay" id="delete"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('25'); // ФОРМА УДАЛЕНИЯ ОБЪЯВЛЕНИЯ ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>

<a href="#x" class="overlay" id="pay-vip"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('35'); // ПОМЕСТИТЬ ОБЪЯВЛЕНИЕ В VIP ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>

<a href="#x" class="overlay" id="pay-color"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('36'); // ФОРМА ВЫДЕЛЕНИЯ ОБЪЯВЛЕНИЯ ЦВЕТОМ ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>

<a href="#x" class="overlay" id="pay-top"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('37'); // ФОРМА ПОДНЯТИЯ ОБЪЯВЛЕНИЯ ВВЕРХ ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>

<a href="#x" class="overlay" id="pay-home"></a>
<div class="popup">
	<?php echo RSFormProHelper::displayForm('38'); // ФОРМА ДОБАВЛЕНИЯ ОБЪЯВЛЕНИЯ НА ГЛАВНУЮ ?>		
<a class="close1" title="Закрыть" href="#close"></a>	
</div>


    <?php } ?>
</div>
