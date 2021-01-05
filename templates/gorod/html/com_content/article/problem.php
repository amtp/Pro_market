<?php
defined('_JEXEC') or die;
use Joomla\Registry\Registry;
JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');
$authorised = JFactory::getUser()->getAuthorisedViewLevels();
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
$rating_user = $template->params->get('rating_user', '');
$money_no = $template->params->get('money_no', '');
$domen = JUri::base();
foreach($this->item->jcfields as $field) { 
		$f[$field->id] = $field->value;
	}
$phone= $f[2];	

	$date_now = date("d.m.Y G:i:s");
    $date = $f[104]; //выделение цветом
    $d = new DateTime($date);
    $d->modify('+'.$f[103].' day');
    $data_color_end = $d->format("d.m.Y G:i:s");//выделение цветом	
	

?>
			<?php $dir = opendir(''.JPATH_BASE.'/images/problem/'.$item_id.'');
				$count_photo = 0;
				while($file = readdir($dir)){
				if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/problem/'.$item_id.'' . $file)){
					continue;
				}
				$count_photo++;
			} ?>
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
<script type="text/javascript">
ymaps.ready(init); 
function init () { 
    var myMap = new ymaps.Map("YMapsID", { 
		<?php if($f[108]) { ?>
			center: [<?php echo $f[108] ?>], 
        <?php } else { ?>
			center: [<?php echo $center_map ?>], 
        <?php }  ?>
		zoom: 15, 
		controls: ['zoomControl']
	});
	
	
	var geocode = ymaps.geocode('г. <?php echo $gorod ?>, <?php echo $f[106] ?>', {results: 1});
	geocode.then(
		function (res) {
			<?php if($f[108]) { ?>
			<?php } else { ?>
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
			<?php } ?>
			

			<?php if($f[108]) { ?>
			myPlacemark = new ymaps.Placemark([<?php echo $f[108] ?>], { 
				// Чтобы балун и хинт открывались на метке, необходимо задать ей определенные свойства. 
				balloonContentHeader: '<div class="problem_img"><div class="problem_status"><?php echo $f[107] ?></div><?php if($count_photo == 0) { ?><img src="/images/no_image.jpg" width="200px"/><?php } else { ?><img src="<?php echo $images->image_intro ?>" width="250px"/><?php } ?> </div> <a href="<?php echo $link ?>"><?php echo $this->item->title ?></a>', 
				balloonContentBody: "<div>г. <?php echo $gorod ?>, <?php echo $f[106] ?></div>", 
				balloonContentFooter: "<div></div>", 
				hintContent: "<?php echo $this->item->title ?>"
			}, {
				iconLayout: 'default#image',
				<?php if($this->item->catid == '1978') { ?>
					iconImageHref: '/images/problem/icons/musor.png',
				<?php } ?>
				<?php if($this->item->catid == '1977') { ?>
					iconImageHref: '/images/problem/icons/yami.png',
				<?php } ?>
				<?php if($this->item->catid == '1980') { ?>
					iconImageHref: '/images/problem/icons/parkovka.png',
				<?php } ?>
				<?php if($this->item->catid == '1981') { ?>
					iconImageHref: '/images/problem/icons/np.png',
				<?php } ?>
				<?php if($this->item->catid == '1982') { ?>
					iconImageHref: '/images/problem/icons/sneg.png',
				<?php } ?>
				<?php if($this->item->catid == '1983') { ?>	
					iconImageHref: '/images/problem/icons/other.png',
				<?php } ?>
				iconImageSize: [25, 35],
				iconImageOffset: [-17, -35]
			}); 	 			
			<?php } else { ?>
			myPlacemark = new ymaps.Placemark(coords, { 
				// Чтобы балун и хинт открывались на метке, необходимо задать ей определенные свойства. 
				balloonContentHeader: '<div class="problem_img"><div class="problem_status"><?php echo $f[107] ?></div><?php if($count_photo == 0) { ?><img src="/images/no_image.jpg" width="200px"/><?php } else { ?><img src="<?php echo $images->image_intro ?>" width="250px"/><?php } ?> </div> <a href="<?php echo $link ?>"><?php echo $this->item->title ?></a>', 
				balloonContentBody: "<div>г. <?php echo $gorod ?>, <?php echo $f[106] ?></div>", 
				balloonContentFooter: "<div></div>", 
				hintContent: "<?php echo $this->item->title ?>" 
			}, {
				iconLayout: 'default#image',
				<?php if($this->item->catid == '1978') { ?>
					iconImageHref: '/images/problem/icons/musor.png',
				<?php } ?>
				<?php if($this->item->catid == '1977') { ?>
					iconImageHref: '/images/problem/icons/yami.png',
				<?php } ?>
				<?php if($this->item->catid == '1980') { ?>
					iconImageHref: '/images/problem/icons/parkovka.png',
				<?php } ?>
				<?php if($this->item->catid == '1981') { ?>
					iconImageHref: '/images/problem/icons/np.png',
				<?php } ?>
				<?php if($this->item->catid == '1982') { ?>
					iconImageHref: '/images/problem/icons/sneg.png',
				<?php } ?>
				<?php if($this->item->catid == '1983') { ?>	
					iconImageHref: '/images/problem/icons/other.png',
				<?php } ?>				
				iconImageSize: [25, 35],
				iconImageOffset: [-17, -35]
			}); 				
			<?php } ?>

			myMap.geoObjects.add(myPlacemark); 
		},
		function (err) {
		}
	);
} 
</script>

<div class="firma-page<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Organization">
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
	

	<div class="mini_icons">
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
	</div
	>

	<div id="YMapsID">
		<span class="loading">
			<i class="fa fa-spinner fa-spin"></i>
			<span>Загружаем карту</span>
		</span>
		<div class="map_info">
		<div class="firma_logo" >

			<?php if($count_photo > 0) { ?>
				<div class="problem_img"><div class="problem_status"><?php echo $f[107] ?></div><?php echo JHtml::_('content.prepare', '{gallery preview-width=230 preview-height=165}problem/'.$item_id.'{/gallery}'); ?></div>
			<?php } else { ?>
				<div class="problem_img"><div class="problem_status"><?php echo $f[107] ?></div>
					<img itemprop="logo" class="lazy" src="/images/no_image.jpg" width="200px">
				</div>
			<?php } ?>
		</div>
		<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
		<div class="mini_icons">
			<div class="ic_cat">
				<i class="fa fa-map-marker"></i>
				<span itemprop="streetAddress"><?php echo $f[106] ?></span>
			</div>
	
		</div>
		</div>
		</div>
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


<div class="tabs">
    <input id="tab1" type="radio" name="tabs" checked>
    <label for="tab1" title="Описание"><i class="fa fa-files-o"></i> Описание</label>

    <input id="tab3" type="radio" name="tabs">
    <label for="tab3" title="Отзывы"><i class="fa fa-comments-o"></i> Отзывы
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
	
    <input id="tab2" type="radio" name="tabs">
    <label for="tab2" title="Видео"><i class="fa fa-address-book"></i> Официальный ответ</label>	


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
	
	<section id="content-tab2">
		<?php if($f[109]) { ?>
			<?php echo $f[109] ?>
		<?php } else { ?>
			Официального ответа пока нет
		<?php } ?>
    </section> 	
 
</div>	
</div>
